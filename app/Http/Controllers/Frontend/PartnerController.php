<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::published()->displayOrder()->paginate(24);
        return view('frontend.partners.index', compact('partners'));
    }
}
