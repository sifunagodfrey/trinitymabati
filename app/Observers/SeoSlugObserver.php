<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeoSlugObserver
{
    public function updated(Model $model): void
    {
        if (!$model->wasChanged('slug')) return;
        $old = $model->getRawOriginal('slug');
        if (!$old || $old === $model->slug) return;
        $kind = $model instanceof \App\Models\Manage\Products\Product ? 'product' : 'category';
        DB::table('su_seo_slug_redirects')->updateOrInsert(['kind' => $kind, 'old_slug' => $old], [
            'entity_id' => $model->id, 'created_at' => now(),
        ]);
        DB::table('su_seo_slug_redirects')->where('kind', $kind)->where('old_slug', $model->slug)->delete();
        $route = $kind === 'product' ? 'frontend.products.show' : 'frontend.categories.show';
        $metadata = DB::table('su_seo_metadata')->where('route_name', $route);
        if (!(clone $metadata)->where('resource_slug', $model->slug)->exists()) {
            (clone $metadata)->where('resource_slug', $old)->update(['resource_slug' => $model->slug, 'updated_at' => now()]);
        }
    }
}
