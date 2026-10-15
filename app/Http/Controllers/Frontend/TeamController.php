<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::published()->displayOrder()->paginate(16);
        return view('frontend.team.index', compact('members'));
    }
}
