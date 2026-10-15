<?php

namespace App\Services\Seo;

use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeoService
{
    public const DESCRIPTION = 'Trinity Mabati Factory delivers genuine, KEBS-certified metal roofing sheets with an ironclad 15-year written warranty directly to your construction site.';
    public const HOME_TITLE = 'Trinity Mabati Factory | Quality Roofing Sheets in Kenya';

    public function indexable(Request $request): bool
    {
        if (!app()->environment('production') || Setting::get('seo_indexing_enabled', '1') !== '1') return false;
        $adminHost = (string) config('seo.admin_domain', '');
        if ($adminHost !== '' && strcasecmp($request->getHost(), $adminHost) === 0) return false;
        if (!$request->routeIs('frontend.*', 'home')) return false;
        if ($request->routeIs('frontend.search*', 'frontend.cart*', 'frontend.checkout*', 'frontend.account',
            'frontend.favorites', 'frontend.track-order*', 'frontend.referral.*', 'frontend.quotation.search')) return false;
        foreach (['search', 'q', 'sort', 'min_price', 'max_price', 'price_range', 'brand_id', 'label_id', 'category_id', 'category', 'condition', 'profile', 'location'] as $key) {
            if ($request->filled($key)) return false;
        }
        return true;
    }

    public function canonical(Request $request): string
    {
        $name = $request->route()?->getName();
        $url = match ($name) {
            'frontend.projects' => route('frontend.project-gallery'),
            'frontend.contact.us' => route('frontend.contact'),
            default => $request->url(),
        };
        $page = filter_var($request->query('page'), FILTER_VALIDATE_INT);
        $paginated = $request->routeIs('frontend.products', 'frontend.categories', 'frontend.categories.show',
            'frontend.project-gallery', 'frontend.projects', 'frontend.blog', 'frontend.testimonials', 'frontend.brands.show');
        return $paginated && $page && $page > 1 ? $url . '?page=' . $page : $url;
    }

    public function metadata(array $data): array
    {
        $request = request();
        $home = $request->routeIs('frontend.home', 'home');
        $product = $data['product'] ?? null;
        $category = $data['categoryModel'] ?? null;
        $page = $data['page'] ?? null;
        $post = $data['post'] ?? null;
        $project = $data['project'] ?? null;
        $slug = (string) ($request->route('slug') ?? '');
        // Homepage metadata is intentionally excluded from admin overrides.
        $override = $home ? null : DB::table('su_seo_metadata')
            ->where('route_name', $request->route()?->getName() ?? '')
            ->where('resource_slug', $slug)->first();
        $title = $home ? self::HOME_TITLE : ($override?->meta_title ?: null);
        $description = $home ? self::DESCRIPTION : ($override?->meta_description ?: null);
        $image = url('public/images/trinity-mabati-home-seo.jpg');
        if ($product && $request->routeIs('frontend.products.show')) {
            $title ??= $product->name . ' | Trinity Mabati Factory';
            $description ??= $product->short_description ?: ('Explore ' . $product->name . ' roofing products from Trinity Mabati Factory.');
            $image = $this->productImage($product->thumbnail) ?? $image;
        } elseif ($category) {
            $title ??= $category->name . ' | Trinity Mabati Factory';
            $description ??= $category->description ?: ('Explore ' . $category->name . ' roofing products from Trinity Mabati Factory.');
        } elseif ($page) {
            $title ??= ($page->meta_title ?: $page->title) . ' | Trinity Mabati Factory';
            $description ??= $page->meta_description ?: Str::limit(strip_tags($page->content ?? ''), 160, '');
        } elseif ($post) {
            $title ??= $post->title . ' | Trinity Mabati Factory';
            $description ??= $post->excerpt ?: Str::limit(strip_tags($post->content ?? ''), 160, '');
            $image = $post->banner || $post->thumbnail ? asset($post->banner ?: $post->thumbnail) : $image;
        } elseif ($project) {
            $title ??= $project->title . ' | Trinity Mabati Factory';
            $description ??= $project->description ?: self::DESCRIPTION;
        }
        $defaults = [
            'frontend.about' => 'Learn about Trinity Mabati Factory, our roofing products, quality standards and commitment to dependable delivery in Kenya.',
            'frontend.contact' => 'Contact Trinity Mabati Factory for roofing advice, product enquiries and assistance from our Nairobi and Migori outlets.',
            'frontend.products' => 'Browse roofing sheets and accessories from Trinity Mabati Factory. Compare available profiles, gauges, finishes and prices.',
            'frontend.categories' => 'Explore Trinity Mabati Factory roofing categories and find the right sheet profile and accessories for your construction project.',
            'frontend.team' => 'Meet the team at Trinity Mabati Factory and the people helping customers choose roofing products for their projects.',
            'frontend.partners' => 'Discover the partners working with Trinity Mabati Factory to support our roofing products and services.',
            'frontend.project-gallery' => 'Explore recent roofing projects completed with Trinity Mabati Factory products and find inspiration for your next roof.',
            'frontend.faq' => 'Find answers about roofing sheet gauges, profiles, quotations, delivery and warranties at Trinity Mabati Factory.',
            'frontend.blog' => 'Read roofing advice, product guides and updates from Trinity Mabati Factory to help plan your next construction project.',
            'frontend.quotation.index' => 'Request a roofing quotation from Trinity Mabati Factory. Choose products, sheet lengths and quantities for your project.',
            'frontend.testimonials' => 'Read customer experiences and reviews of Trinity Mabati Factory roofing products and service.',
            'frontend.downloads' => 'Find available roofing product downloads and resources from Trinity Mabati Factory.',
        ];
        $description ??= $defaults[$request->route()?->getName() ?? ''] ?? null;
        return [
            'title' => $title, 'description' => $description ? $this->plain($description) : null,
            'image' => $image, 'canonical' => $this->canonical($request),
            'robots' => $this->indexable($request) ? 'index, follow, max-image-preview:large' : 'noindex, follow',
            'schemas' => $this->schemas($data, $image),
        ];
    }

    public function productImage(?string $path): ?string
    {
        if (!$path) return null;
        if (Str::startsWith($path, ['https://', 'http://'])) return $path;
        return asset(Str::startsWith($path, ['uploads/', 'storage/']) ? $path : 'uploads/products/images/' . $path);
    }

    private function plain(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    private function schemas(array $data, string $image): array
    {
        $site = $data['site'] ?? Setting::siteContact();
        $branding = $data['branding'] ?? Setting::siteBranding();
        $organization = [
            '@context' => 'https://schema.org', '@type' => 'Organization', '@id' => url('/') . '#organization',
            'name' => 'Trinity Mabati Factory', 'url' => url('/'), 'logo' => $branding['logo_main'],
            'image' => url('public/images/trinity-mabati-home-seo.jpg'), 'description' => self::DESCRIPTION,
        ];
        if ($site['email'] ?? null) $organization['email'] = $site['email'];
        if ($site['phone'] ?? null) $organization['telephone'] = $site['phone'];
        if ($site['socials'] ?? []) $organization['sameAs'] = array_values($site['socials']);
        $schemas = [$organization];
        if (request()->routeIs('frontend.contact', 'frontend.contact.us')) {
            foreach ($site['branches'] ?? [] as $index => $branch) {
                if (empty($branch['address']) || empty($branch['name'])) continue;
                $schemas[] = [
                    '@context' => 'https://schema.org', '@type' => 'LocalBusiness', '@id' => url('/contact') . '#branch-' . $index,
                    'name' => 'Trinity Mabati Factory — ' . $branch['name'], 'url' => route('frontend.contact'),
                    'image' => $image, 'telephone' => $branch['phone'],
                    'address' => ['@type' => 'PostalAddress', 'streetAddress' => $branch['address'], 'addressCountry' => 'KE'],
                    'parentOrganization' => ['@id' => url('/') . '#organization'],
                ];
            }
        }
        if (request()->routeIs('frontend.products.show') && ($product = $data['product'] ?? null)) {
            $schema = [
                '@context' => 'https://schema.org', '@type' => 'Product',
                'name' => $product->name, 'url' => route('frontend.products.show', $product->slug),
                'description' => $this->plain($product->short_description ?: $product->name),
            ];
            if ($this->productImage($product->thumbnail)) $schema['image'] = [$image];
            if ($product->sku) $schema['sku'] = $product->sku;
            if ($product->brand?->name) $schema['brand'] = ['@type' => 'Brand', 'name' => $product->brand->name];
            $length = $product->allow_custom_length ? (float) ($product->default_length_m ?? 1) : 1;
            $price = (float) ($data['variantMinPrice'] ?? $data['basePrice'] ?? 0) * $length;
            $stock = $product->is_variant ? $product->variants->sum('stock_quantity') : $product->stock_quantity;
            if ($price > 0) {
                $max = (float) ($data['variantMaxPrice'] ?? $data['variantMinPrice'] ?? $data['basePrice'] ?? 0) * $length;
                $offer = ['@type' => $max > $price ? 'AggregateOffer' : 'Offer', 'priceCurrency' => 'KES',
                    'url' => route('frontend.products.show', $product->slug)];
                if ($max > $price) {
                    $offer += ['lowPrice' => number_format($price, 2, '.', ''), 'highPrice' => number_format($max, 2, '.', ''), 'offerCount' => $product->variants->count()];
                } else {
                    $offer += ['price' => number_format($price, 2, '.', ''), 'availability' => 'https://schema.org/' . ($stock > 0 ? 'InStock' : 'OutOfStock')];
                }
                $schema['offers'] = $offer;
            }
            $schemas[] = $schema;
        }
        $crumbs = $data['breadcrumb'] ?? [];
        if (request()->routeIs('frontend.products.show') && isset($data['product'])) {
            $product = $data['product'];
            $crumbs = [['label' => 'Home', 'url' => route('frontend.home')], ['label' => 'Products', 'url' => route('frontend.products')]];
            if ($product->category) $crumbs[] = ['label' => $product->category->name, 'url' => route('frontend.categories.show', $product->category->slug)];
            $crumbs[] = ['label' => $product->name, 'url' => null];
        }
        if ($crumbs) {
            $items = [];
            foreach ($crumbs as $i => $crumb) {
                $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['label'], 'item' => $crumb['url'] ?: $this->canonical(request())];
            }
            $schemas[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
        }
        return $schemas;
    }
}
