<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AjaxSearchController extends Controller
{
    // ---------------
    // Live-search endpoint - GET /manage/ajax/search?type=orders&q=...
    // Returns up to 8 results as: [{id, label, sublabel?, url}]
    // ---------------
    public function search(Request $request): JsonResponse
    {
        $q    = Str::lower(trim($request->get('q', '')));
        $type = $request->get('type', '');

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $results = match ($type) {
            'orders'             => $this->orders($q),
            'returns'            => $this->returns($q),
            'customers'          => $this->customers($q),
            'products'           => $this->products($q),
            'blog_posts'         => $this->blogPosts($q),
            'messages'           => $this->messages($q),
            'system_users'       => $this->systemUsers($q),
            'newsletters'        => $this->newsletters($q),
            'contact_messages'   => $this->contactMessages($q),
            'discounts'          => $this->discounts($q),
            'referral_codes'     => $this->referralCodes($q),
            'flash_sales'        => $this->flashSales($q),
            'reviews'            => $this->reviews($q),
            'shipping_pricing'   => $this->shippingPricing($q),
            'visitors'           => $this->visitors($q),
            'pages'              => $this->pages($q),
            'faqs'               => $this->faqs($q),
            default              => [],
        };

        return response()->json(['results' => $results]);
    }

    // ---------------
    // Orders
    // ---------------
    private function orders(string $q): array
    {
        return DB::table('su_orders as o')
            ->join('su_users as u', 'u.id', '=', 'o.user_id')
            ->where(function ($w) use ($q) {
                $w->where('o.order_code', 'like', "%{$q}%")
                  ->orWhere(DB::raw("LOWER(CONCAT(u.first_name,' ',u.last_name))"), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(u.email)'), 'like', "%{$q}%");
            })
            ->orderByDesc('o.created_at')
            ->limit(8)
            ->get(['o.id', 'o.order_code', 'u.first_name', 'u.last_name', 'o.status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->order_code,
                'sublabel' => $r->first_name . ' ' . $r->last_name . ' - ' . ucfirst($r->status),
                'url'      => url('/manage/ecommerce/orders/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Order Returns
    // ---------------
    private function returns(string $q): array
    {
        return DB::table('su_order_returns as r')
            ->join('su_orders as o', 'o.id', '=', 'r.order_id')
            ->join('su_users as u', 'u.id', '=', 'r.user_id')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(o.order_code)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw("LOWER(CONCAT(u.first_name,' ',u.last_name))"), 'like', "%{$q}%");
            })
            ->orderByDesc('r.created_at')
            ->limit(8)
            ->get(['r.id', 'o.order_code', 'u.first_name', 'u.last_name', 'r.status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->order_code,
                'sublabel' => $r->first_name . ' ' . $r->last_name . ' - ' . ucfirst($r->status),
                'url'      => url('/manage/ecommerce/returns/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Customers
    // ---------------
    private function customers(string $q): array
    {
        return DB::table('su_users')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw("LOWER(CONCAT(first_name,' ',last_name))"), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'first_name', 'last_name', 'email', 'status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->first_name . ' ' . $r->last_name,
                'sublabel' => $r->email,
                'url'      => url('/manage/ecommerce/customers/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Products
    // ---------------
    private function products(string $q): array
    {
        return DB::table('su_products as p')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(p.name)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(p.sku)'), 'like', "%{$q}%");
            })
            ->orderByDesc('p.created_at')
            ->limit(8)
            ->get(['p.id', 'p.name', 'p.sku'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->name,
                'sublabel' => 'SKU: ' . $r->sku,
                'url'      => url('/manage/products/all/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Blog Posts
    // ---------------
    private function blogPosts(string $q): array
    {
        return DB::table('su_blog_posts')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(title)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(excerpt)'), 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'title', 'is_published'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->title,
                'sublabel' => $r->is_published ? 'Published' : 'Draft',
                'url'      => url('/manage/blogs/posts/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // User Messages
    // ---------------
    private function messages(string $q): array
    {
        return DB::table('su_user_messages')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(subject)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(message)'), 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'subject', 'status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->subject,
                'sublabel' => ucfirst($r->status),
                'url'      => url('/manage/messages/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // System / Admin Users
    // ---------------
    private function systemUsers(string $q): array
    {
        return DB::table('su_users')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw("LOWER(CONCAT(first_name,' ',last_name))"), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'first_name', 'last_name', 'email', 'status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->first_name . ' ' . $r->last_name,
                'sublabel' => $r->email,
                'url'      => url('/manage/system-users/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Newsletters
    // ---------------
    private function newsletters(string $q): array
    {
        return DB::table('su_newsletters')
            ->where(DB::raw('LOWER(subject)'), 'like', "%{$q}%")
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'subject', 'status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->subject,
                'sublabel' => $r->status,
                'url'      => url('/manage/newsletters'),
            ])->toArray();
    }

    // ---------------
    // Contact Messages
    // ---------------
    private function contactMessages(string $q): array
    {
        return DB::table('su_contact_messages')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(subject)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(name)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'like', "%{$q}%");
            })
            ->orderByDesc('received_at')
            ->limit(8)
            ->get(['id', 'subject', 'name', 'email'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->subject,
                'sublabel' => $r->name . ' - ' . $r->email,
                'url'      => url('/manage/contact/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Discount Codes
    // ---------------
    private function discounts(string $q): array
    {
        return DB::table('su_discounts')
            ->where(DB::raw('LOWER(code)'), 'like', "%{$q}%")
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['id', 'code', 'status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->code,
                'sublabel' => ucfirst($r->status),
                'url'      => url('/manage/ecommerce/coupons'),
            ])->toArray();
    }

    // ---------------
    // Referral Codes
    // ---------------
    private function referralCodes(string $q): array
    {
        return DB::table('su_referral_codes as rc')
            ->join('su_users as u', 'u.id', '=', 'rc.user_id')
            ->where(DB::raw('LOWER(rc.code)'), 'like', "%{$q}%")
            ->orWhere(DB::raw('LOWER(u.email)'), 'like', "%{$q}%")
            ->orderByDesc('rc.id')
            ->limit(8)
            ->get(['rc.id', 'rc.code', 'u.first_name', 'u.last_name'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->code,
                'sublabel' => trim($r->first_name . ' ' . $r->last_name),
                'url'      => url('/manage/ecommerce/referrals'),
            ])->toArray();
    }

    // ---------------
    // Flash Sales
    // ---------------
    private function flashSales(string $q): array
    {
        return DB::table('su_flash_sales as fs')
            ->join('su_products as p', 'p.id', '=', 'fs.product_id')
            ->where(DB::raw('LOWER(p.name)'), 'like', "%{$q}%")
            ->orderByDesc('fs.start_time')
            ->limit(8)
            ->get(['fs.id', 'p.name', 'fs.status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->name,
                'sublabel' => ucfirst($r->status),
                'url'      => url('/manage/ecommerce/flash-sales/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Product Reviews
    // ---------------
    private function reviews(string $q): array
    {
        return DB::table('su_product_reviews as rv')
            ->join('su_products as p', 'p.id', '=', 'rv.product_id')
            ->join('su_users as u', 'u.id', '=', 'rv.user_id')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(p.name)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw("LOWER(CONCAT(u.first_name,' ',u.last_name))"), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(rv.comment)'), 'like', "%{$q}%");
            })
            ->orderByDesc('rv.created_at')
            ->limit(8)
            ->get(['rv.id', 'p.name', 'u.first_name', 'u.last_name', 'rv.status'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->name,
                'sublabel' => $r->first_name . ' ' . $r->last_name . ' - ' . ucfirst($r->status),
                'url'      => url('/manage/ecommerce/reviews/' . $r->id),
            ])->toArray();
    }

    // ---------------
    // Shipping / Location Pricing
    // ---------------
    private function shippingPricing(string $q): array
    {
        return DB::table('su_location_pricing as lp')
            ->leftJoin('su_counties as c', 'c.id', '=', 'lp.county_id')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(lp.location_name)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(c.name)'), 'like', "%{$q}%");
            })
            ->orderBy('lp.location_name')
            ->limit(8)
            ->get(['lp.id', 'lp.location_name', 'c.name as county'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->location_name,
                'sublabel' => $r->county ?? '',
                'url'      => url('/manage/shipping/pricing'),
            ])->toArray();
    }

    // ---------------
    // Visitor Logs
    // ---------------
    private function visitors(string $q): array
    {
        return DB::table('su_visitors_logs')
            ->where(function ($w) use ($q) {
                $w->where('ip_address', 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(visited_url)'), 'like', "%{$q}%");
            })
            ->orderByDesc('visit_time')
            ->limit(8)
            ->get(['id', 'ip_address', 'visited_url', 'visit_time'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->ip_address,
                'sublabel' => $r->visited_url,
                'url'      => url('/manage/visitors-log'),
            ])->toArray();
    }
    // ---------------
    // Site Pages
    // ---------------
    private function pages(string $q): array
    {
        return DB::table('su_pages')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(title)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(slug)'), 'like', "%{$q}%");
            })
            ->orderBy('title')
            ->limit(8)
            ->get(['id', 'title', 'slug', 'is_active'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->title,
                'sublabel' => '/' . $r->slug . ($r->is_active ? '' : ' (inactive)'),
                'url'      => url('/manage/content/pages/' . $r->id . '/edit'),
            ])->toArray();
    }

    // ---------------
    // FAQs
    // ---------------
    private function faqs(string $q): array
    {
        return DB::table('su_faqs')
            ->where(function ($w) use ($q) {
                $w->where(DB::raw('LOWER(question)'), 'like', "%{$q}%")
                  ->orWhere(DB::raw('LOWER(answer)'), 'like', "%{$q}%");
            })
            ->orderBy('position')
            ->limit(8)
            ->get(['id', 'question', 'is_active'])
            ->map(fn ($r) => [
                'id'       => $r->id,
                'label'    => $r->question,
                'sublabel' => $r->is_active ? 'Active' : 'Inactive',
                'url'      => url('/manage/content/faqs/' . $r->id . '/edit'),
            ])->toArray();
    }
}
