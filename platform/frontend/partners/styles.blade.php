{{-- Shared by the homepage and directories; no asset rebuild required. --}}
<style>
.trinity-network { --network-accent:var(--primary-color, #bb1c28); padding:clamp(3rem,6vw,5.5rem) 0; background:#fff; }
.trinity-network--associations { background:var(--background-color, #faf5f3); }
.trinity-network__inner { box-sizing:border-box; width:100%; max-width:80rem; margin-inline:auto; padding-inline:1rem; }
.trinity-network__header { display:flex; align-items:flex-end; justify-content:space-between; gap:1.5rem; margin-bottom:2rem; }
.trinity-network__intro { max-width:40rem; min-width:0; }
.trinity-network__eyebrow { display:block; margin-bottom:.65rem; color:var(--network-accent); font:600 .7rem/1.5 var(--font-ui, sans-serif); letter-spacing:.16em; text-transform:uppercase; }
.trinity-network__title { margin:0; color:var(--network-accent); font:800 clamp(1.85rem,3.5vw,2.75rem)/1.15 var(--font-heading, sans-serif); letter-spacing:-.025em; overflow-wrap:anywhere; }
.trinity-network__description { margin:.85rem 0 0; color:#647084; font-size:.95rem; line-height:1.8; }
.trinity-network__actions { display:flex; align-items:center; gap:1.25rem; flex-shrink:0; }
.trinity-network__link { display:inline-flex; align-items:center; gap:.6rem; min-height:44px; color:var(--network-accent); font:500 .85rem/1.4 var(--font-ui, sans-serif); text-decoration:none; }
.trinity-network__link:hover { text-decoration:underline; text-underline-offset:5px; }
.trinity-network__controls { display:flex; gap:.5rem; }
.trinity-network__button { display:grid; place-items:center; width:44px; height:44px; padding:0; border:1px solid #dce0e5; border-radius:50%; background:#fff; color:var(--network-accent); cursor:pointer; transition:border-color .2s, background .2s; }
.trinity-network__button:hover:not(:disabled) { border-color:var(--network-accent); background:var(--primary-light, #faf5f3); }
.trinity-network__button:disabled { opacity:.35; cursor:default; }
.trinity-network__button svg { width:18px; height:18px; }
.trinity-network__rail { --network-columns:1.92; --network-gap:12px; display:grid; grid-auto-flow:column; grid-auto-columns:calc((100% - (var(--network-columns) - 1)*var(--network-gap))/var(--network-columns)); gap:var(--network-gap); overflow-x:auto; overscroll-behavior-x:contain; scroll-snap-type:x mandatory; scroll-padding-inline:0; padding:6px 0 18px; scrollbar-width:thin; scrollbar-color:#cbd1d9 transparent; }
.trinity-network--home .trinity-network__rail { scrollbar-width:none; -ms-overflow-style:none; }
.trinity-network--home .trinity-network__rail::-webkit-scrollbar { display:none; width:0; height:0; }
.trinity-network-card { display:flex; min-width:0; height:100%; margin:0; flex-direction:column; overflow:hidden; border:1px solid #e5e7eb; border-radius:4px; background:#fff; box-shadow:0 4px 16px rgb(20 30 45 / 3%); scroll-snap-align:start; transition:transform .2s, box-shadow .2s, border-color .2s; }
.trinity-network-card__image { display:flex; align-items:center; justify-content:center; height:160px; padding:28px; }
.trinity-network-card__image img { display:block; width:100%; height:100%; object-fit:contain; }
.trinity-network-card figcaption { padding:16px 20px; margin-top:auto; border-top:1px solid #f0f1f3; color:#374151; font:500 .8rem/1.6 var(--font-ui, sans-serif); text-align:center; overflow-wrap:anywhere; }
.trinity-network__empty { padding:2rem; border:1px dashed #dce0e5; border-radius:18px; text-align:center; color:#647084; }
.trinity-network__hint { margin:.75rem 0 0; color:#647084; font-size:.75rem; line-height:1.6; }
.trinity-network__pagination { margin-top:2rem; }
.trinity-network :is(a,button,[tabindex]):focus-visible { outline:3px solid var(--network-accent); outline-offset:3px; }
@media (hover:hover) and (prefers-reduced-motion:no-preference) { .trinity-network-card:hover { transform:translateY(-3px); border-color:#cbd1d9; box-shadow:0 12px 24px rgb(20 30 45 / 7%); } }
@media (min-width:640px) { .trinity-network__inner { padding-inline:1.5rem; } .trinity-network__rail { --network-columns:2; --network-gap:20px; } .trinity-network-card__image { height:180px; padding:32px; } }
@media (min-width:1024px) { .trinity-network__inner { padding-inline:2rem; } .trinity-network__rail { --network-columns:4; --network-gap:24px; } .trinity-network--associations .trinity-network__rail { --network-columns:3; } }
@media (max-width:639px) { .trinity-network-card__image { height:130px; padding:16px; } .trinity-network-card figcaption { padding:12px 10px; } .trinity-network__header { align-items:flex-start; flex-direction:column; gap:1rem; margin-bottom:1.25rem; } .trinity-network__actions { width:100%; justify-content:space-between; } .trinity-network__controls { margin-left:auto; } }
@media (prefers-reduced-motion:reduce) { .trinity-network *, .trinity-network *::before, .trinity-network *::after { transition:none !important; scroll-behavior:auto !important; } }
/* Directory pages wrap every entry into rows; homepage rows remain scrollable. */
.trinity-network__grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; align-items:stretch; }
@media (min-width:640px) { .trinity-network__grid { gap:20px; } }
@media (min-width:1024px) {
    .trinity-network__grid { grid-template-columns:repeat(4,minmax(0,1fr)); gap:24px; }
    .trinity-network--associations .trinity-network__grid { grid-template-columns:repeat(3,minmax(0,1fr)); }
}
</style>
