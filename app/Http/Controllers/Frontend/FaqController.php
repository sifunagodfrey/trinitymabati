<?php

/* -------------------
   Frontend FAQ controller. Renders the public frequently asked
   questions page from su_faqs.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    // ---------------
    // FAQ page
    // ---------------
    public function index(): View
    {
        $faqs = Faq::activeOrdered()->get();

        return view('frontend.faq.index', compact('faqs'));
    }
}
