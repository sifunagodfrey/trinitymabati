<figure class="trinity-network-card">
    <div class="trinity-network-card__image">
        <img src="{{ asset($partner->image) }}" alt="{{ ($duplicate ?? false) ? '' : $partner->name }}" loading="lazy" decoding="async">
    </div>
    @unless ($duplicate ?? false)
        <figcaption>{{ $partner->name }}</figcaption>
    @endunless
</figure>
