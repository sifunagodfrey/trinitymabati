<?php

namespace App\Providers;

use App\Models\Manage\Products\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['frontend.partials.header', 'frontend.layouts.app'],
            function ($view) {
                $view->with('parentCategories', Category::whereNull('parent_id')
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug']));
            }
        );
    }
}