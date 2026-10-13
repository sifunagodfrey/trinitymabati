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
    // ---------------
    // Show a page by slug
    // ---------------
    public function show(string $slug): View
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
