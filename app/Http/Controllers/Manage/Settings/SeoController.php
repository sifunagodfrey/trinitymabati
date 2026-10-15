<?php

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Models\Core\Page;
use App\Models\Frontend\Blog;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $targets = $this->targets();
        $selected = (string) $request->query('target', array_key_first($targets));
        if (!array_key_exists($selected, $targets)) $selected = array_key_first($targets);
        [$route, $slug] = explode('|', $selected, 2);
        $metadata = DB::table('su_seo_metadata')->where('route_name', $route)->where('resource_slug', $slug)->first();
        $settings = Setting::allCached();
        return view('manage.settings.seo.index', compact('targets', 'selected', 'metadata', 'settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'ga4_measurement_id' => ['nullable', 'string', 'regex:/^G-[A-Z0-9]+$/', 'max:40'],
            'google_site_verification' => ['nullable', 'string', 'max:200', 'regex:/^[A-Za-z0-9_-]+$/'],
            'ga4_enabled' => ['nullable', 'boolean'], 'seo_indexing_enabled' => ['nullable', 'boolean'],
            'seo_canonical_redirect' => ['nullable', 'boolean'],
        ]);
        if ($request->boolean('ga4_enabled') && empty($data['ga4_measurement_id'])) {
            return back()->withErrors(['ga4_measurement_id' => 'Enter your GA4 measurement ID before enabling Analytics.'])->withInput();
        }
        foreach (['ga4_measurement_id', 'google_site_verification'] as $key) Setting::put($key, $data[$key] ?? '');
        foreach (['ga4_enabled', 'seo_indexing_enabled', 'seo_canonical_redirect'] as $key) Setting::put($key, $request->boolean($key) ? '1' : '0');
        return back()->with('success', 'SEO and Analytics settings saved.');
    }

    public function metadata(Request $request)
    {
        $data = $request->validate([
            'target' => ['required', Rule::in(array_keys($this->targets()))],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);
        [$route, $slug] = explode('|', $data['target'], 2);
        $key = ['route_name' => $route, 'resource_slug' => $slug];
        if (empty($data['meta_title']) && empty($data['meta_description'])) {
            DB::table('su_seo_metadata')->where($key)->delete();
        } else {
            $existing = DB::table('su_seo_metadata')->where($key)->first();
            DB::table('su_seo_metadata')->updateOrInsert($key, [
                'meta_title' => $data['meta_title'] ?? null, 'meta_description' => $data['meta_description'] ?? null,
                'created_at' => $existing?->created_at ?? now(), 'updated_at' => now(),
            ]);
        }
        return redirect()->route('manage.settings.seo.index', ['target' => $data['target']])->with('success', 'Page metadata saved.');
    }

    private function targets(): array
    {
        $targets = [];
        foreach (['about' => 'About Us', 'categories' => 'Categories', 'products' => 'Products', 'contact' => 'Contact Us',
            'team' => 'Our Team', 'partners' => 'Partners', 'project-gallery' => 'Project Gallery', 'faq' => 'FAQs',
            'blog' => 'Blog', 'quotation.index' => 'Request a Quotation', 'testimonials' => 'Testimonials',
            'privacy-policy.public' => 'Privacy Policy', 'terms' => 'Terms and Conditions', 'refund-policy' => 'Refund Policy',
            'cookie-policy' => 'Cookie Policy', 'downloads' => 'Downloads'] as $route => $label) {
            $targets['frontend.' . $route . '|'] = $label;
        }
        foreach (Product::where('is_active', true)->orderBy('name')->get(['name', 'slug']) as $row) {
            $targets['frontend.products.show|' . $row->slug] = 'Product: ' . $row->name;
        }
        foreach (Category::orderBy('name')->get(['name', 'slug']) as $row) {
            $targets['frontend.categories.show|' . $row->slug] = 'Category: ' . $row->name;
        }
        foreach (Blog::published()->orderBy('title')->get(['title', 'slug']) as $row) {
            $targets['frontend.blog.show|' . $row->slug] = 'Blog: ' . $row->title;
        }
        foreach (Page::active()->orderBy('title')->get(['title', 'slug']) as $row) {
            if (in_array($row->slug, ['privacy-policy', 'terms-and-conditions', 'terms-conditions', 'refund-policy', 'cookie-policy'], true)) continue;
            $targets['frontend.pages.show|' . $row->slug] = 'Page: ' . $row->title;
        }
        return $targets;
    }
}
