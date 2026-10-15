@once
<style>
.trinity-team-card {
    display:flex; flex-direction:column; min-width:0; margin:0; padding:0;
    border:0; border-radius:0; background:#fff; box-shadow:none;
}
.trinity-team-portrait {
    position:relative; width:100%; aspect-ratio:1/1; overflow:hidden;
    border:0; border-radius:0; background:#f3f4f6;
}
.trinity-team-photo {
    position:absolute; inset:0; display:block; width:100%; height:100%;
    object-fit:cover; object-position:center 30%; border-radius:0;
}
.trinity-team-placeholder {
    display:flex; align-items:center; justify-content:center;
    font-size:36px; color:var(--primary-color,#ad1f2b);
}
.trinity-team-details { position:static; flex:1; padding:12px 14px 16px; text-align:left; background:#fff; }
.trinity-team-name {
    margin:0; color:var(--primary-color,#ad1f2b); font-weight:600;
    font-size:16px; line-height:1.4; overflow-wrap:anywhere;
}
.trinity-team-title {
    margin:4px 0 0; color:#6b7280; font-weight:400;
    font-size:13px; line-height:1.5; overflow-wrap:anywhere;
}
@media(max-width:639px) {
    .trinity-team-name { font-size:14px; }
    .trinity-team-title { font-size:12px; }
}
</style>
@endonce
<article class="trinity-team-card">
    <div class="trinity-team-portrait">
        @if ($member->photo)
            <img src="{{ asset($member->photo) }}" alt="{{ $member->full_name }}" class="trinity-team-photo" loading="lazy" decoding="async" width="480" height="480">
        @else
            <div class="trinity-team-photo trinity-team-placeholder" aria-hidden="true"><i class="fas fa-user"></i></div>
        @endif
    </div>
    <div class="trinity-team-details">
        <h3 class="trinity-team-name">{{ $member->full_name }}</h3>
        @if ($member->title)
            <p class="trinity-team-title">{{ $member->title }}</p>
        @endif
    </div>
</article>
