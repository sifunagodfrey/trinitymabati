// -------------------
// Bootstrap
// -------------------
import './bootstrap';

// -------------------
// Alpine Setup
// -------------------
import Alpine from 'alpinejs';

window.Alpine = Alpine;


// =======================================================
// GLOBAL MENU REGISTRY (fixes accordion + active state)
// =======================================================
window.__menuRegistry = {
    activeKey: null,
    menus: {}
};

// =======================================================
// LAYOUT STATE (Sidebar + Theme System)
// =======================================================
window.layout = function () {
    return {

        // -------------------
        // Sidebar State
        // -------------------
        collapsed: false,

        // -------------------
        // Theme State
        // -------------------
        theme: 'system',
        darkMode: false,

        // -------------------
        // INIT
        // -------------------
        init() {

            // Sidebar
            const sidebar = localStorage.getItem('sidebar_collapsed');
            if (sidebar !== null) {
                this.collapsed = sidebar === 'true';
            }

            // Theme
            this.theme = localStorage.getItem('theme') || 'system';

            // IMPORTANT: listen to system theme changes
            window.matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', () => {
                    if (this.theme === 'system') {
                        this.applyTheme();
                    }
                });

            this.applyTheme();
        },

        // -------------------
        // APPLY THEME
        // -------------------
        applyTheme() {

            const root = document.documentElement;

            if (this.theme === 'system') {
                this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            } else {
                this.darkMode = this.theme === 'dark';
            }

            // Apply class
            root.classList.toggle('dark', this.darkMode);

            // persist
            localStorage.setItem('theme', this.theme);
        },

        // -------------------
        // SIDEBAR TOGGLE
        // -------------------
        toggleSidebar() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar_collapsed', this.collapsed);
        },

        // -------------------
        // SET THEME
        // -------------------
        setTheme(mode) {
            this.theme = mode;
            this.applyTheme();
        },

        // -------------------
        // FIXED TOGGLE (THIS IS WHAT WAS MISSING)
        // -------------------
        toggleDarkMode() {

            if (this.theme === 'system') {
                this.theme = 'dark';
            } else if (this.theme === 'dark') {
                this.theme = 'light';
            } else {
                this.theme = 'dark';
            }

            this.applyTheme();
        }
    };
};


// =======================================================
// MENU STATE MANAGER
// =======================================================
window.menuState = function (key, routeMatch = false) {
    return {

        // -------------------
        // STATE
        // -------------------
        open: false,
        hover: false,
        key: key,

        // -------------------
        // INIT
        // -------------------
        init() {

            // register menu
            window.__menuRegistry.menus[key] = this;

            // restore state
            const saved = localStorage.getItem('menu_' + key);

            if (saved !== null) {
                this.open = saved === 'true';
            }

            // AUTO OPEN if route matches
            if (routeMatch) {
                this.open = true;
                window.__menuRegistry.activeKey = key;
            }
        },

        // -------------------
        // CHECK ACTIVE STATE
        // -------------------
        isActive() {
            return window.__menuRegistry.activeKey === key;
        },

        // -------------------
        // TOGGLE (ACCORDION FIX)
        // -------------------
        toggle() {

            const willOpen = !this.open;

            // close all other menus
            Object.keys(window.__menuRegistry.menus).forEach(menuKey => {
                const menu = window.__menuRegistry.menus[menuKey];
                if (menuKey !== key && menu) {
                    menu.open = false;
                }
            });

            this.open = willOpen;

            if (willOpen) {
                window.__menuRegistry.activeKey = key;
            } else if (window.__menuRegistry.activeKey === key) {
                window.__menuRegistry.activeKey = null;
            }

            localStorage.setItem('menu_' + key, this.open);
        }
    };
};


// =======================================================
// CART STORE - single reactive source of truth for the badge
// =======================================================
document.addEventListener('alpine:init', () => {
    Alpine.store('cart', { count: (typeof window.__cartCount === 'number' ? window.__cartCount : 0) });

    // ---------------
    // Product rail - one-row scroller with left/right controls.
    // Used by the homepage category and product rails.
    // ---------------
    Alpine.data('productRail', () => ({
        prev() {
            this.$refs.track.scrollBy({ left: -this.$refs.track.clientWidth * 0.9, behavior: 'smooth' });
        },
        next() {
            this.$refs.track.scrollBy({ left: this.$refs.track.clientWidth * 0.9, behavior: 'smooth' });
        },
    }));
});

// =======================================================
// CART ADD - intercept all add-to-cart form submissions
// =======================================================
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form.action || !form.action.includes('/cart/add')) return;

    e.preventDefault();

    const btn          = form.querySelector('[type="submit"]');
    const originalHtml = btn ? btn.innerHTML : null;

    if (btn) {
        btn.disabled  = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
    }

    fetch(form.action, {
        method : 'POST',
        body   : new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept'          : 'application/json',
        },
    })
        .then(r => r.json())
        .then(data => {
            // ---------------
            // Write directly to the Alpine store - reactive on every page
            // ---------------
            if (data.success) {
                Alpine.store('cart').count = data.count;
                showCartToast('Added to cart');

                // ---------------
                // Product-card forms become a View Cart link without a refresh
                // ---------------
                if (form.classList.contains('js-card-add')) {
                    const link     = document.createElement('a');
                    link.href      = form.dataset.cartUrl || '/cart';
                    link.className = 'flex items-center justify-center gap-1.5 w-full text-xs font-bold ' +
                        'text-primary border-2 border-primary bg-white hover:bg-primary hover:text-white ' +
                        'rounded-[8px] py-2.5 transition';
                    link.innerHTML = '<i class="fas fa-cart-shopping text-[10px]"></i> View Cart';
                    form.replaceWith(link);
                }
            }
        })
        .catch(() => {})
        .finally(() => {
            if (btn) {
                btn.disabled  = false;
                btn.innerHTML = originalHtml;
            }
        });
});

// =======================================================
// CART TOAST - lightweight feedback without a page refresh
// =======================================================
function showCartToast(message) {
    let toast = document.getElementById('cart-toast');

    if (!toast) {
        toast = document.createElement('div');
        toast.id        = 'cart-toast';
        toast.className = 'fixed left-1/2 -translate-x-1/2 bottom-20 md:bottom-8 z-[9999] ' +
            'bg-gray-900 text-white text-sm font-semibold px-5 py-3 rounded-[12px] shadow-lg ' +
            'flex items-center gap-2 transition-opacity duration-300 opacity-0 pointer-events-none';
        toast.innerHTML = '<i class="fas fa-check-circle text-green-400"></i><span></span>';
        document.body.appendChild(toast);
    }

    toast.querySelector('span').textContent = message;
    toast.classList.remove('opacity-0');

    clearTimeout(toast._hideTimer);
    toast._hideTimer = setTimeout(() => toast.classList.add('opacity-0'), 1800);
}

// =======================================================
// START ALPINE
// =======================================================
Alpine.start();