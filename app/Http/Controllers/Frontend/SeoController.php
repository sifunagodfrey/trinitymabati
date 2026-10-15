<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Models\Core\Page;
use App\Models\Frontend\Blog;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SeoController extends Controller
{
    private const SIZE = 1000;

    public function robots()
    {
        $adminHost = (string) config('seo.admin_domain', '');
        $enabled = app()->environment('production') && Setting::get('seo_indexing_enabled', '1') === '1'
            && ($adminHost === '' || strcasecmp(request()->getHost(), $adminHost) !== 0);
        $body = $enabled
            ? "User-agent: *\nAllow: /\nSitemap: " . route('seo.sitemap') . "\n"
            : "User-agent: *\nDisallow: /\n";
        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function index()
    {
        $xml = Cache::remember($this->key('index'), 300, function () {
            $entries = [['loc' => route('seo.sitemap.part', ['type' => 'pages', 'page' => 1])]];
            foreach (['products', 'categories', 'projects', 'blog', 'content'] as $type) {
                $pages = (int) ceil($this->query($type)->count() / self::SIZE);
                for ($page = 1; $page <= $pages; $page++) {
                    $entries[] = ['loc' => route('seo.sitemap.part', compact('type', 'page'))];
                }
            }
            return $this->xml($entries, true);
        });
        return response($xml)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function part(string $type, int $page)
    {
        abort_unless(in_array($type, ['pages', 'products', 'categories', 'projects', 'blog', 'content'], true) && $page > 0, 404);
        $xml = Cache::remember($this->key($type . ':' . $page), 300, function () use ($type, $page) {
            $entries = [];
            if ($type === 'pages') {
                abort_unless($page === 1, 404);
                foreach (['frontend.home', 'frontend.about', 'frontend.categories', 'frontend.products', 'frontend.contact',
                    'frontend.team', 'frontend.partners', 'frontend.project-gallery', 'frontend.faq', 'frontend.blog',
                    'frontend.quotation.index', 'frontend.testimonials', 'frontend.downloads'] as $name) {
                    if (Route::has($name)) $entries[] = ['loc' => route($name)];
                }
            } else {
                $rows = $this->query($type)->orderBy('id')->forPage($page, self::SIZE)->get();
                abort_if($rows->isEmpty(), 404);
                foreach ($rows as $row) {
                    $route = match ($type) {
                        'products' => 'frontend.products.show', 'categories' => 'frontend.categories.show',
                        'projects' => 'frontend.projects.show', 'blog' => 'frontend.blog.show', default => 'frontend.pages.show',
                    };
                    $loc = $type === 'content' ? $this->pageUrl($row->slug) : route($route, $row->slug);
                    $entry = ['loc' => $loc];
                    // Avoid using product/blog updated_at: view counters also change it.
                    if ($type === 'content' || $type === 'projects') {
                        if ($row->updated_at) $entry['lastmod'] = \Illuminate\Support\Carbon::parse($row->updated_at)->toAtomString();
                    }
                    $entries[] = $entry;
                }
            }
            return $this->xml($entries);
        });
        return response($xml)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function pageUrl(string $slug): string
    {
        return match ($slug) {
            'privacy-policy' => route('frontend.privacy-policy.public'),
            'terms-and-conditions', 'terms-conditions' => route('frontend.terms'),
            'refund-policy' => route('frontend.refund-policy'), 'cookie-policy' => route('frontend.cookie-policy'),
            default => route('frontend.pages.show', $slug),
        };
    }

    private function query(string $type)
    {
        return match ($type) {
            'products' => Product::query()->where('is_active', true)->whereNotNull('slug')->where('slug', '!=', ''),
            'categories' => Category::query()->whereNotNull('slug')->where('slug', '!=', ''),
            'projects' => DB::table('su_client_projects')->where('is_published', true),
            'blog' => Blog::published(),
            'content' => Page::active(),
        };
    }

    private function key(string $suffix): string
    {
        return 'seo:sitemap:' . hash('sha256', url('/')) . ':' . $suffix;
    }

    private function xml(array $entries, bool $index = false): string
    {
        $escape = fn ($value) => htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $root = $index ? 'sitemapindex' : 'urlset';
        $tag = $index ? 'sitemap' : 'url';
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n<{$root} xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        foreach ($entries as $entry) {
            $xml .= "<{$tag}><loc>" . $escape($entry['loc']) . '</loc>';
            if (isset($entry['lastmod'])) $xml .= '<lastmod>' . $escape($entry['lastmod']) . '</lastmod>';
            $xml .= "</{$tag}>\n";
        }
        return $xml . "</{$root}>";
    }
}
