{{-- ---------------
-- Predictive / Searchable Select & Live Search
-- Loaded once from manage.layouts.app - auto-initialises on all pages.
--
-- Searchable Select: wraps every <select> (except those opted out) with a
--   type-to-filter combo box.  The original select stays hidden in the DOM
--   so form submission and native change events are unaffected.
--
-- Live Search: attaches to every input[name="search"] and shows a
--   clickable result dropdown via GET /manage/ajax/search.
-- --------------- --}}

<script>
(function () {

    // ---------------
    // Skip-condition helpers
    // ---------------
    function shouldSkipSelect(select) {
        if (select.dataset.searchableInit)              return true;
        if ('noSearch' in select.dataset)               return true;
        if (select.hasAttribute('x-model'))             return true;
        if (select.hasAttribute(':value'))              return true;
        if (select.hasAttribute('x-bind:value'))        return true;
        if (select.hasAttribute(':name'))               return true;
        if (select.closest('template'))                 return true;
        if (select.closest('.ql-toolbar'))              return true;
        return false;
    }

    // ---------------
    // Upgrade one <select> to a searchable combo box
    // ---------------
    function upgradeSelect(select) {
        if (shouldSkipSelect(select)) return;
        select.dataset.searchableInit = '1';

        // ---------------
        // Build DOM: wrapper > [input, dropdown, select(hidden)]
        // ---------------
        const wrapper = document.createElement('div');
        wrapper.className = 'relative searchable-select-wrapper';
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);

        // Proxy text input - inherits the select's visual classes
        const input = document.createElement('input');
        input.type        = 'text';
        input.autocomplete = 'off';
        input.spellcheck  = false;
        input.className   = select.className + ' cursor-pointer';
        input.placeholder = select.options[0]?.text || 'Type to search…';

        // Transfer required from the hidden select to the visible proxy
        if (select.required) {
            select.required = false;
            input.required  = true;
        }

        // Dropdown list
        const dropdown = document.createElement('ul');
        dropdown.className = [
            'hidden absolute z-[200] left-0 w-full mt-1 bg-white',
            'border border-gray-200 rounded-[12px] shadow-xl',
            'overflow-y-auto max-h-60 text-sm',
        ].join(' ');

        wrapper.insertBefore(input, select);
        wrapper.appendChild(dropdown);

        // Hide the original select (stays in DOM for form submission)
        Object.assign(select.style, {
            position:      'absolute',
            width:         '1px',
            height:        '1px',
            overflow:      'hidden',
            opacity:       '0',
            pointerEvents: 'none',
        });

        // ---------------
        // Reflect initial selection in the proxy input
        // ---------------
        const initialOpt = Array.from(select.options).find(o => o.selected && o.value !== '');
        if (initialOpt) input.value = initialOpt.text;

        // ---------------
        // Render dropdown items filtered by query
        // ---------------
        function renderDropdown(query) {
            const q    = query.toLowerCase().trim();
            const opts = Array.from(select.options);
            const hits = q ? opts.filter(o => o.text.toLowerCase().includes(q)) : opts;

            dropdown.innerHTML = '';

            if (!hits.length) {
                const empty = document.createElement('li');
                empty.className = 'px-4 py-2.5 text-gray-400 italic text-xs select-none';
                empty.textContent = 'No matches found';
                dropdown.appendChild(empty);
                return;
            }

            hits.forEach(opt => {
                const li = document.createElement('li');
                li.className = [
                    'px-4 py-2.5 cursor-pointer text-gray-800 truncate',
                    'hover:bg-gray-50 transition-colors',
                    opt.selected && opt.value !== '' ? 'bg-primary/10 text-primary font-medium' : '',
                ].join(' ');
                li.textContent  = opt.text;
                li.dataset.value = opt.value;

                li.addEventListener('mousedown', e => {
                    e.preventDefault();
                    pick(opt.value, opt.text);
                    close();
                });

                dropdown.appendChild(li);
            });
        }

        // ---------------
        // Select an option - updates hidden select + proxy + fires change
        // ---------------
        function pick(value, text) {
            select.value  = value;
            input.value   = value === '' ? '' : text;

            if (input.required) {
                input.setCustomValidity(value === '' ? 'Please select an option.' : '');
            }

            // Fire change so onchange="this.form.submit()" and other listeners still work
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function open() {
            renderDropdown(input.value);
            dropdown.classList.remove('hidden');
            highlight(null);
        }

        function close() {
            dropdown.classList.add('hidden');
        }

        // ---------------
        // Keyboard navigation helper
        // ---------------
        function highlight(li) {
            dropdown.querySelectorAll('[data-highlighted]').forEach(el => {
                el.removeAttribute('data-highlighted');
                el.classList.remove('bg-primary/10', 'text-primary', 'font-medium');
            });
            if (li) {
                li.dataset.highlighted = '1';
                li.classList.add('bg-primary/10', 'text-primary', 'font-medium');
                li.scrollIntoView({ block: 'nearest' });
            }
        }

        // ---------------
        // Events
        // ---------------
        input.addEventListener('focus', () => {
            input.select();
            open();
        });

        input.addEventListener('input', () => {
            renderDropdown(input.value);
            dropdown.classList.remove('hidden');
        });

        input.addEventListener('keydown', e => {
            const items = Array.from(dropdown.querySelectorAll('li[data-value]'));
            const cur   = dropdown.querySelector('[data-highlighted]');
            const idx   = items.indexOf(cur);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlight(items[idx + 1] ?? items[0]);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlight(items[idx - 1] ?? items[items.length - 1]);
            } else if (e.key === 'Enter') {
                const hi = dropdown.querySelector('[data-highlighted]');
                if (hi) {
                    e.preventDefault();
                    pick(hi.dataset.value, hi.textContent.trim());
                    close();
                }
            } else if (e.key === 'Escape' || e.key === 'Tab') {
                close();
            }
        });

        // Restore visible text if user blurs without picking
        input.addEventListener('blur', () => {
            setTimeout(() => {
                if (!wrapper.contains(document.activeElement)) {
                    const cur = Array.from(select.options).find(o => o.selected && o.value !== '');
                    if (!input.value && cur) input.value = cur.text;
                    close();
                }
            }, 150);
        });

        // Close when clicking outside
        document.addEventListener('click', e => {
            if (!wrapper.contains(e.target)) close();
        }, { passive: true });
    }

    // ---------------
    // Live search for index-page search bars
    // ---------------

    // Map form-action URL segments → resource type token sent to the backend
    const TYPE_MAP = {
        'ecommerce/orders':          'orders',
        'ecommerce/returns':         'returns',
        'ecommerce/customers':       'customers',
        'ecommerce/abandoned-carts': 'abandoned_carts',
        'ecommerce/coupons':         'discounts',
        'ecommerce/referrals':       'referral_codes',
        'ecommerce/flash-sales':     'flash_sales',
        'ecommerce/reviews':         'reviews',
        'ecommerce/invoices':        'invoices',
        'products/all':              'products',
        'products/reports':          'products',
        'blogs/posts':               'blog_posts',
        'messages':                  'messages',
        'newsletters':               'newsletters',
        'visitors-log':              'visitors',
        'system-users':              'system_users',
        'shipping/pricing':          'shipping_pricing',
        'contact':                   'contact_messages',
        'media':                     'products',
        'content/pages':             'pages',
        'content/faqs':              'faqs',
    };

    function typeFromFormAction(form) {
        if (!form) return null;
        const action = (form.getAttribute('action') || '').replace(/\?.*/, '');
        const segment = action.replace(/^.*\/manage\//, '').replace(/\/+$/, '');
        return TYPE_MAP[segment] ?? null;
    }

    // ---------------
    // Attach live search to a search input
    // ---------------
    function initLiveSearch(input) {
        if (input.dataset.liveSearchInit) return;
        const form = input.closest('form');
        const type = typeFromFormAction(form);
        if (!type) return;

        input.dataset.liveSearchInit = '1';

        const parent = input.parentElement;
        if (getComputedStyle(parent).position === 'static') {
            parent.style.position = 'relative';
        }

        const dropdown = document.createElement('div');
        dropdown.className = [
            'hidden absolute z-[300] left-0 right-0 top-full mt-1',
            'bg-white border border-gray-200 rounded-[12px] shadow-xl',
            'overflow-y-auto max-h-80 text-sm',
        ].join(' ');
        parent.appendChild(dropdown);

        let timer     = null;
        let lastQuery = '';

        input.addEventListener('input', () => {
            const q = input.value.trim();
            clearTimeout(timer);
            if (q.length < 2) { dropdown.classList.add('hidden'); return; }
            if (q === lastQuery) return;
            timer = setTimeout(() => fetchResults(q), 280);
        });

        input.addEventListener('keydown', e => {
            const items = Array.from(dropdown.querySelectorAll('a[data-url]'));
            const cur   = dropdown.querySelector('[data-ls-active]');
            const idx   = items.indexOf(cur);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                lsHighlight(items[idx + 1] ?? items[0], cur);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                lsHighlight(items[idx - 1] ?? items[items.length - 1], cur);
            } else if (e.key === 'Enter') {
                const hi = dropdown.querySelector('[data-ls-active]');
                if (hi) { e.preventDefault(); window.location.href = hi.dataset.url; }
            } else if (e.key === 'Escape') {
                dropdown.classList.add('hidden');
            }
        });

        function lsHighlight(next, prev) {
            if (prev) { delete prev.dataset.lsActive; prev.classList.remove('bg-primary/10'); }
            if (next) { next.dataset.lsActive = '1';  next.classList.add('bg-primary/10'); next.scrollIntoView({ block: 'nearest' }); }
        }

        async function fetchResults(q) {
            lastQuery = q;
            try {
                const res = await fetch(
                    '/manage/ajax/search?type=' + encodeURIComponent(type) +
                    '&q=' + encodeURIComponent(q),
                    { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }
                );
                if (!res.ok) return;
                const data = await res.json();
                renderResults(data.results || []);
            } catch (_) {}
        }

        function renderResults(results) {
            dropdown.innerHTML = '';
            if (!results.length) {
                const empty = document.createElement('div');
                empty.className = 'px-4 py-3 text-gray-400 italic text-xs';
                empty.textContent = 'No results found';
                dropdown.appendChild(empty);
                dropdown.classList.remove('hidden');
                return;
            }
            results.forEach(r => {
                const a = document.createElement('a');
                a.href           = r.url;
                a.dataset.url    = r.url;
                a.className      = 'flex flex-col px-4 py-2.5 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition-colors';
                a.innerHTML      =
                    '<span class="font-medium text-gray-800 truncate">' + esc(r.label)    + '</span>' +
                    (r.sublabel ? '<span class="text-xs text-gray-400 truncate">' + esc(r.sublabel) + '</span>' : '');
                dropdown.appendChild(a);
            });
            dropdown.classList.remove('hidden');
        }

        document.addEventListener('click', e => {
            if (!parent.contains(e.target)) dropdown.classList.add('hidden');
        }, { passive: true });
    }

    // ---------------
    // HTML-escape helper
    // ---------------
    function esc(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ---------------
    // Bootstrap: upgrade all selects + attach live search
    // ---------------
    function init() {
        document.querySelectorAll('select').forEach(upgradeSelect);
        document.querySelectorAll('input[name="search"], input[type="search"]').forEach(initLiveSearch);
    }

    // ---------------
    // MutationObserver - handles Alpine.js x-if / modals adding new elements
    // ---------------
    const observer = new MutationObserver(mutations => {
        mutations.forEach(m => {
            m.addedNodes.forEach(node => {
                if (node.nodeType !== 1) return;
                // Defer slightly so Alpine can finish rendering x-for options inside the new node
                setTimeout(() => {
                    if (node.tagName === 'SELECT') upgradeSelect(node);
                    node.querySelectorAll?.('select').forEach(upgradeSelect);
                    if (node.tagName === 'INPUT' && (node.name === 'search' || node.type === 'search')) initLiveSearch(node);
                    node.querySelectorAll?.('input[name="search"], input[type="search"]').forEach(initLiveSearch);
                }, 80);
            });
        });
    });

    // ---------------
    // Wait for Alpine to finish its initial pass, then run
    // ---------------
    if (document.readyState === 'complete') {
        init();
        observer.observe(document.body, { childList: true, subtree: true });
    } else {
        window.addEventListener('load', () => {
            init();
            observer.observe(document.body, { childList: true, subtree: true });
        });
    }

})();
</script>
