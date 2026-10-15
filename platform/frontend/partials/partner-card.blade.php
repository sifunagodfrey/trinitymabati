<figure class="m-0 overflow-hidden rounded-xl border border-gray-200 bg-white" style="aspect-ratio:2/1;">
    <img src="{{ asset($partner->image) }}" alt="{{ ($duplicate ?? false) ? '' : $partner->name }}" loading="lazy" style="display:block;width:100%;height:100%;object-fit:cover;">
</figure>
