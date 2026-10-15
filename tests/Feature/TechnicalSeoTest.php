<?php

namespace Tests\Feature;

use App\Models\Core\Setting;
use App\Services\Seo\SeoService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TechnicalSeoTest extends TestCase
{
    use DatabaseTransactions;

    private function requestFor(string $url, string $name): Request
    {
        $request = Request::create($url);
        $route = new Route('GET', '/seo-test', fn () => 'ok');
        $route->name($name);
        $request->setRouteResolver(fn () => $route);
        $this->app->instance('request', $request);
        return $request;
    }

    public function test_homepage_metadata_cannot_be_overridden(): void
    {
        $this->requestFor('https://example.test/', 'frontend.home');
        DB::table('su_seo_metadata')->insert(['route_name' => 'frontend.home', 'resource_slug' => '', 'meta_title' => 'Changed', 'meta_description' => 'Changed']);
        $meta = app(SeoService::class)->metadata([]);
        $this->assertSame('Trinity Mabati Factory | Quality Roofing Sheets in Kenya', $meta['title']);
        $this->assertSame(SeoService::DESCRIPTION, $meta['description']);
    }

    public function test_tracking_parameters_are_removed_but_pagination_is_preserved(): void
    {
        $request = $this->requestFor('https://example.test/products?page=2&utm_source=test', 'frontend.products');
        $this->assertSame('https://example.test/products?page=2', app(SeoService::class)->canonical($request));
    }

    public function test_only_production_public_unfiltered_pages_are_indexable(): void
    {
        Setting::put('seo_indexing_enabled', '1');
        $service = app(SeoService::class);
        $this->app['env'] = 'production';
        $this->assertTrue($service->indexable($this->requestFor('https://example.test/products', 'frontend.products')));
        $this->assertFalse($service->indexable($this->requestFor('https://example.test/products?search=roof', 'frontend.products')));
        $this->assertFalse($service->indexable($this->requestFor('https://example.test/checkout', 'frontend.checkout')));
        $this->assertFalse($service->indexable($this->requestFor('https://example.test/account', 'client.dashboard')));
        $this->app['env'] = 'staging';
        $this->assertFalse($service->indexable($this->requestFor('https://example.test/products', 'frontend.products')));
    }

    public function test_page_metadata_uses_database_override(): void
    {
        $this->requestFor('https://example.test/contact', 'frontend.contact');
        DB::table('su_seo_metadata')->insert(['route_name' => 'frontend.contact', 'resource_slug' => '', 'meta_title' => 'Roofing Advice', 'meta_description' => 'Speak to our team.']);
        $meta = app(SeoService::class)->metadata([]);
        $this->assertSame('Roofing Advice', $meta['title']);
        $this->assertSame('Speak to our team.', $meta['description']);
    }

    public function test_sitemap_is_xml_and_does_not_list_private_pages(): void
    {
        $response = $this->get('/sitemaps/pages/1.xml');
        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->assertStringNotContainsString('/checkout', $response->getContent());
        $this->assertStringNotContainsString('/manage', $response->getContent());
        $this->assertStringContainsString('/project-gallery', $response->getContent());
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_purchase_event_requires_paid_order_owned_by_current_user(): void
    {
        Setting::put('ga4_enabled', '1');
        Setting::put('ga4_measurement_id', 'G-TEST123');
        $this->app['env'] = 'production';
        $this->requestFor('https://example.test/client/orders/1', 'client.orders.show');
        $order = (object) ['payment_status' => 'pending', 'user_id' => 1];
        $html = view('frontend.partials.analytics', compact('order'))->render();
        $this->assertStringNotContainsString('transaction_id":', $html);
    }
}
