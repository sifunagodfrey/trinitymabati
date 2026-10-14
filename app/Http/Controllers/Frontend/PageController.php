<?php

/* -------------------
   Frontend page controller. Renders editable site pages such as the
   refund policy, terms and conditions and privacy policy from su_pages.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function privacyPolicy(): View
    {
        return $this->show('privacy-policy');
    }

    public function termsConditions(): View
    {
        return $this->show('terms-and-conditions');
    }

    public function refundPolicy(): View
    {
        return $this->show('refund-policy');
    }

    // ---------------
    // Show a page by slug
    // ---------------
    public function show(string $slug): View
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
