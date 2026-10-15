<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientStoriesController extends Controller
{
    public function testimonials()
    {
        $testimonials = DB::table('su_client_testimonials')->where('is_published', true)
            ->orderByDesc('is_featured')->orderBy('sort_order')->latest()->paginate(12);
        return view('frontend.testimonials.index', compact('testimonials'));
    }

    public function projects(Request $request)
    {
        $published = DB::table('su_client_projects')->where('is_published', true);
        $showFilters = (clone $published)->count() > 20
            && (clone $published)->whereNotNull('roofing_profile')->where('roofing_profile', '!=', '')
                ->distinct()->count('roofing_profile') > 8;
        $filters = $showFilters ? $request->validate([
            'q' => ['nullable', 'string', 'max:160'],
            'profile' => ['nullable', 'string', 'max:160', \Illuminate\Validation\Rule::exists('su_product_categories', 'name')->whereNull('parent_id')],
            'location' => ['nullable', 'string', 'max:160'],
        ]) : [];
        $profiles = DB::table('su_product_categories')->whereNull('parent_id')->orderBy('name')->pluck('name');
        $locations = DB::table('su_client_projects')->where('is_published', true)
            ->whereNotNull('location')->where('location', '!=', '')
            ->distinct()->orderBy('location')->pluck('location');
        $term = trim($filters['q'] ?? '');
        $projects = DB::table('su_client_projects')->where('is_published', true)
            ->when($filters['profile'] ?? null, fn ($query, $profile) => $query->where('roofing_profile', $profile))
            ->when($filters['location'] ?? null, fn ($query, $location) => $query->where('location', $location))
            ->when($term !== '', function ($query) use ($term) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $term) . '%';
                $query->where(fn ($search) => $search->where('title', 'like', $like)->orWhere('description', 'like', $like));
            })
            ->orderByDesc('is_featured')->orderBy('sort_order')->latest()->paginate(20)->withQueryString();
        return view('frontend.projects.index', compact('projects', 'profiles', 'locations', 'filters', 'showFilters'));
    }

    public function project(string $slug)
    {
        $project = DB::table('su_client_projects')->where('slug', $slug)->where('is_published', true)->first();
        abort_unless($project, 404);
        $gallery = json_decode($project->gallery ?: '[]', true) ?: [];
        return view('frontend.projects.show', compact('project', 'gallery'));
    }
}
