<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClientStoriesController extends Controller
{
    public function testimonials()
    {
        $testimonials = DB::table('su_client_testimonials')->where('is_published', true)
            ->orderByDesc('is_featured')->orderBy('sort_order')->latest()->paginate(12);
        return view('frontend.testimonials.index', compact('testimonials'));
    }

    public function projects()
    {
        $projects = DB::table('su_client_projects')->where('is_published', true)
            ->orderByDesc('is_featured')->orderBy('sort_order')->latest()->paginate(12);
        return view('frontend.projects.index', compact('projects'));
    }

    public function project(string $slug)
    {
        $project = DB::table('su_client_projects')->where('slug', $slug)->where('is_published', true)->first();
        abort_unless($project, 404);
        $gallery = json_decode($project->gallery ?: '[]', true) ?: [];
        return view('frontend.projects.show', compact('project', 'gallery'));
    }
}
