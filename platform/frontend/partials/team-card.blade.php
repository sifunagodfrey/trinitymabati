@once
<style>
.trinity-team-card {
    position:relative; box-sizing:border-box; display:flex; align-items:center; justify-content:center;
    aspect-ratio:1/1; overflow:hidden; padding:clamp(16px,2.2vw,28px);
    border:1px solid #e9e5e3; border-radius:12px; background:#fff;
    box-shadow:0 2px 8px rgba(28,22,20,.025); outline-offset:4px;
    transition:border-color .25s ease,box-shadow .25s ease;
}
.trinity-team-portrait {
    position:relative; isolation:isolate; box-sizing:border-box; width:100%; aspect-ratio:1/1;
    overflow:hidden; border:1px solid var(--primary-color,#ad1f2b); border-radius:50%; background:#f4f3f2;
    box-shadow:0 0 0 5px #fff,0 0 0 6px rgba(173,31,43,.08);
}
.trinity-team-photo {
    display:block; width:100%; height:100%; object-fit:cover; object-position:center 30%;
    transition:transform .4s ease,opacity .3s ease;
}
.trinity-team-details {
    position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;
    padding:16px; text-align:center; color:#fff; background:rgba(20,24,30,.84);
    opacity:0; transition:opacity .25s ease;
}
.trinity-team-name { margin:0; color:#fff; font-weight:600; font-size:clamp(13px,1.2vw,17px); line-height:1.4; text-wrap:balance; overflow-wrap:anywhere; }
.trinity-team-title { margin:9px 0 0; color:rgba(255,255,255,.86); font-weight:400; font-size:clamp(10px,1vw,12px); line-height:1.5; letter-spacing:.035em; overflow-wrap:anywhere; }
.trinity-team-card:hover,.trinity-team-card:focus-within { border-color:var(--primary-color,#ad1f2b); box-shadow:0 6px 18px rgba(28,22,20,.07); }
.trinity-team-card:hover .trinity-team-photo,.trinity-team-card:focus-within .trinity-team-photo { transform:scale(1.04); }
.trinity-team-card:hover .trinity-team-details,.trinity-team-card:focus-within .trinity-team-details { opacity:1; }
@media(hover:none) { .trinity-team-details { opacity:1; background:rgba(20,24,30,.66); } }
@media(prefers-reduced-motion:reduce) { .trinity-team-card,.trinity-team-photo,.trinity-team-details { transition:none; } .trinity-team-card:hover .trinity-team-photo,.trinity-team-card:focus-within .trinity-team-photo { transform:none; } }
</style>
@endonce
<article class="trinity-team-card" tabindex="0" aria-label="{{ $member->full_name }}{{ $member->title ? ', ' . $member->title : '' }}">
    <div class="trinity-team-portrait">
        @if($member->photo)<img src="{{ asset($member->photo) }}" alt="{{ $member->full_name }}" class="trinity-team-photo" loading="lazy">@else<div class="trinity-team-photo flex items-center justify-center text-4xl" aria-hidden="true"><i class="fas fa-user"></i></div>@endif
        <div class="trinity-team-details"><h3 class="trinity-team-name">{{ $member->full_name }}</h3>@if($member->title)<p class="trinity-team-title">{{ $member->title }}</p>@endif</div>
    </div>
</article>
