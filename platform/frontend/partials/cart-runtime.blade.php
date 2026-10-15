{{-- -------------------
     Cart Runtime
     Seeds the cart badge with the real server-side count and handles
     add-to-cart submissions with no page refresh. Written inline so it
     works regardless of whether the compiled JS bundle is up to date.
------------------- --}}
<script>
    (function () {
        var INITIAL_CART_COUNT = {{ (int) \App\Services\CartContext::count() }};
        window.__cartCount = INITIAL_CART_COUNT;

        // ---------------
        // Keep the Alpine cart store in sync, seeding it on init
        // ---------------
        document.addEventListener('alpine:init', function () {
            if (window.Alpine && typeof window.Alpine.store === 'function') {
                window.Alpine.store('cart', { count: INITIAL_CART_COUNT });
            }
        });

        // Mirror the count onto any badge elements directly, so the UI
        // updates even if Alpine has not booted on this page.
        function paintBadges(count) {
            window.__cartCount = count;
            document.querySelectorAll('[data-cart-badge]').forEach(function (el) {
                el.textContent = count;
                el.style.display = count > 0 ? 'flex' : 'none';
            });
            try {
                if (window.Alpine && typeof window.Alpine.store === 'function') {
                    window.Alpine.store('cart').count = count;
                }
            } catch (e) {}
        }

        // Expose globally so other scripts (e.g. the product page) can refresh badges
        window.updateCartBadges = paintBadges;

        // Any script can fire this event to refresh the badge count
        window.addEventListener('cart-updated', function (e) {
            if (e && e.detail && typeof e.detail.count !== 'undefined') {
                paintBadges(parseInt(e.detail.count, 10) || 0);
            }
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function () { paintBadges(INITIAL_CART_COUNT); });
        } else {
            paintBadges(INITIAL_CART_COUNT);
        }

        // ---------------
        // Lightweight toast
        // ---------------
        function showToast(message) {
            var toast = document.getElementById('cart-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'cart-toast';
                toast.style.cssText = 'position:fixed;left:50%;transform:translateX(-50%);' +
                    'bottom:5rem;z-index:9999;background:#111827;color:#fff;font-size:.8rem;' +
                    'font-weight:600;padding:.75rem 1.25rem;border-radius:9999px;' +
                    'box-shadow:0 10px 25px rgba(0,0,0,.2);display:flex;align-items:center;gap:.5rem;' +
                    'opacity:0;transition:opacity .3s;pointer-events:none;';
                toast.innerHTML = '<i class="fas fa-check-circle" style="color:#34d399"></i><span></span>';
                document.body.appendChild(toast);
            }
            toast.querySelector('span').textContent = message;
            toast.style.opacity = '1';
            clearTimeout(toast._t);
            toast._t = setTimeout(function () { toast.style.opacity = '0'; }, 1800);
        }

        // ---------------
        // Intercept add-to-cart submissions
        // ---------------
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form || !form.action || form.action.indexOf('/cart/add') === -1) return;
            if (form.dataset.cartBound === '1') { /* still handle */ }

            e.preventDefault();

            var btn = form.querySelector('[type="submit"]');
            var originalHtml = btn ? btn.innerHTML : null;
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data && data.success) {
                        if (data.analytics && window.trinityTrack) window.trinityTrack('add_to_cart', data.analytics);
                        paintBadges(data.count);
                        showToast('Added to cart');

                        if (form.classList.contains('js-card-add')) {
                            var link = document.createElement('a');
                            link.href = form.dataset.cartUrl || '{{ route('frontend.cart') }}';
                            link.className = 'flex items-center justify-center gap-1.5 w-full text-xs font-bold ' +
                                'text-primary border-2 border-primary bg-white hover:bg-primary hover:text-white ' +
                                'rounded-[8px] py-2.5 transition';
                            link.innerHTML = '<i class="fas fa-cart-shopping text-[10px]"></i> View Cart';
                            form.replaceWith(link);
                        }
                    }
                })
                .catch(function () {})
                .finally(function () {
                    if (btn) { btn.disabled = false; btn.innerHTML = originalHtml; }
                });
        });
    })();
</script>
