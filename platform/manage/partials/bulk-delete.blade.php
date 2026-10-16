{{-- ---------------
     Bulk delete bar + behaviour. Include INSIDE the <form> that wraps the table.
     Rows need:  <input type="checkbox" name="ids[]" value="{{ $id }}" class="bulk-check">
     Header:     <input type="checkbox" class="bulk-check-all">
     Params:     $noun (e.g. "orders"), $warning (extra sentence shown in the confirm box)
--------------- --}}
@php
    $noun    = $noun ?? 'records';
    $warning = $warning ?? '';
@endphp
<div data-bulk-bar data-noun="{{ $noun }}" data-warning="{{ $warning }}"
     class="mb-3 hidden items-center justify-between gap-3 rounded-[12px] border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900">
    <span><strong data-bulk-count>0</strong> {{ $noun }} selected</span>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-[10px] bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
        <i class="fa-solid fa-trash"></i>
        Delete selected
    </button>
</div>
<script>
(function () {
    var bar  = document.currentScript.previousElementSibling;
    var form = bar.closest('form');
    if (!form) return;
    var all   = form.querySelector('.bulk-check-all');
    var count = bar.querySelector('[data-bulk-count]');

    function boxes() { return form.querySelectorAll('.bulk-check'); }
    function refresh() {
        var n = form.querySelectorAll('.bulk-check:checked').length;
        count.textContent = n;
        bar.classList.toggle('hidden', n === 0);
        bar.classList.toggle('flex', n > 0);
        if (all) {
            all.checked = n > 0 && n === boxes().length;
            all.indeterminate = n > 0 && n < boxes().length;
        }
    }
    if (all) all.addEventListener('change', function () {
        boxes().forEach(function (b) { b.checked = all.checked; });
        refresh();
    });
    form.addEventListener('change', function (e) {
        if (e.target.classList && e.target.classList.contains('bulk-check')) refresh();
    });
    form.addEventListener('submit', function (e) {
        var n = form.querySelectorAll('.bulk-check:checked').length;
        var msg = 'Permanently delete ' + n + ' ' + bar.dataset.noun + '? ' + (bar.dataset.warning || '') +
                  '\n\nThis cannot be undone.';
        if (!n || !confirm(msg)) e.preventDefault();
    });
})();
</script>
