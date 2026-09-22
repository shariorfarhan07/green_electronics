require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    function bindDrawer(toggleSelector, drawerId, backdropId) {
        var drawer = document.getElementById(drawerId);
        var backdrop = document.getElementById(backdropId);
        if (!drawer || !backdrop) return;

        function open() {
            drawer.classList.add('is-open');
            backdrop.classList.add('is-open');
            document.body.classList.add('no-scroll');
        }
        function close() {
            drawer.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            document.body.classList.remove('no-scroll');
        }

        document.querySelectorAll(toggleSelector).forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                open();
            });
        });
        drawer.querySelectorAll('[data-close]').forEach(function (btn) {
            btn.addEventListener('click', close);
        });
        backdrop.addEventListener('click', close);
    }

    bindDrawer('[data-open="menu"]', 'wb-menu', 'wb-menu-backdrop');
    bindDrawer('[data-open="cart"]', 'wb-cart-drawer', 'wb-cart-backdrop');
    bindDrawer('[data-open="admin-menu"]', 'wb-admin-sidebar', 'wb-admin-sidebar-backdrop');

    // Product detail: gallery thumbnail swap
    document.querySelectorAll('[data-gallery-thumb]').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            var src = thumb.getAttribute('data-full');
            var main = document.querySelector('[data-gallery-main]');
            if (main && src) { main.src = src; }
            document.querySelectorAll('[data-gallery-thumb]').forEach(function (t) { t.classList.remove('is-active'); });
            thumb.classList.add('is-active');
        });
    });

    // Product detail: description / datasheet tabs
    document.querySelectorAll('[data-tab-btn]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var group = btn.closest('[data-tabs]');
            if (!group) return;
            group.querySelectorAll('[data-tab-btn]').forEach(function (b) { b.classList.remove('is-active'); });
            group.querySelectorAll('[data-tab-panel]').forEach(function (p) { p.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var target = group.querySelector('[data-tab-panel="' + btn.getAttribute('data-tab-btn') + '"]');
            if (target) target.classList.add('is-active');
        });
    });

    // Quantity stepper (visual only unless data-href-base is present)
    document.querySelectorAll('[data-qty]').forEach(function (wrap) {
        var input = wrap.querySelector('input');
        var min = parseInt(wrap.getAttribute('data-min') || '1', 10);
        wrap.querySelectorAll('[data-step]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var step = parseInt(btn.getAttribute('data-step'), 10);
                var val = Math.max(min, (parseInt(input.value, 10) || min) + step);
                input.value = val;
                var hrefBase = wrap.getAttribute('data-href-base');
                if (hrefBase) { window.location.href = hrefBase + val; }
            });
        });
    });
});
