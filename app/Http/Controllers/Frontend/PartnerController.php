<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        // ---------------
        // Partners page lists regular partners only (associations are excluded)
        // ---------------
        $partners = Partner::published()->association(false)->displayOrder()->paginate(24);
        return view('frontend.partners.index', compact('partners'));
    }
}
