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

    // Searchable dropdown: enhances a native <select data-searchable> so long
    // option lists (the category tree is ~150 entries) stay navigable. The real
    // <select> is kept in the DOM and stays the submitted value, so the form
    // still works if this never runs.
    document.querySelectorAll('select[data-searchable]').forEach(function (select) {
        var wrap = document.createElement('div');
        wrap.className = 'wb-select';
        select.parentNode.insertBefore(wrap, select);
        wrap.appendChild(select);
        select.style.display = 'none';

        var toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'wb-select__toggle';
        var label = document.createElement('span');
        toggle.appendChild(label);
        toggle.insertAdjacentHTML('beforeend',
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="wb-icon"><path d="m6 9 6 6 6-6"/></svg>');
        wrap.appendChild(toggle);

        var panel = document.createElement('div');
        panel.className = 'wb-select__panel';
        var search = document.createElement('input');
        search.type = 'text';
        search.className = 'wb-select__search';
        search.placeholder = select.getAttribute('data-search-placeholder') || 'Search…';
        var list = document.createElement('div');
        list.className = 'wb-select__list';
        panel.appendChild(search);
        panel.appendChild(list);
        wrap.appendChild(panel);

        function syncLabel() {
            var opt = select.options[select.selectedIndex];
            var text = opt ? opt.text : '';
            if (!text || (opt && !opt.value)) {
                label.className = 'wb-select__placeholder';
                label.textContent = text || 'Select…';
            } else {
                label.className = '';
                label.textContent = text;
            }
        }

        function build(filter) {
            var q = (filter || '').toLowerCase();
            list.innerHTML = '';
            var shown = 0;

            Array.prototype.forEach.call(select.children, function (node) {
                if (node.tagName === 'OPTGROUP') {
                    var matches = Array.prototype.filter.call(node.children, function (o) {
                        return !q || o.text.toLowerCase().indexOf(q) !== -1;
                    });
                    if (!matches.length) return;
                    var head = document.createElement('div');
                    head.className = 'wb-select__group';
                    head.textContent = node.label;
                    list.appendChild(head);
                    matches.forEach(function (o) { list.appendChild(option(o)); shown++; });
                } else if (node.tagName === 'OPTION') {
                    if (q && node.text.toLowerCase().indexOf(q) === -1) return;
                    list.appendChild(option(node));
                    shown++;
                }
            });

            if (!shown) {
                var empty = document.createElement('div');
                empty.className = 'wb-select__empty';
                empty.textContent = 'No matches';
                list.appendChild(empty);
            }
        }

        function option(o) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'wb-select__option' + (o.selected ? ' is-selected' : '');
            btn.textContent = o.text;
            btn.addEventListener('click', function () {
                select.value = o.value;
                select.dispatchEvent(new Event('change', { bubbles: true }));
                syncLabel();
                close();
            });
            return btn;
        }

        function open() {
            wrap.classList.add('is-open');
            build('');
            search.value = '';
            search.focus();
        }
        function close() { wrap.classList.remove('is-open'); }

        toggle.addEventListener('click', function () {
            wrap.classList.contains('is-open') ? close() : open();
        });
        search.addEventListener('input', function () { build(search.value); });
        search.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { close(); toggle.focus(); }
            if (e.key === 'Enter') {
                e.preventDefault();
                var first = list.querySelector('.wb-select__option');
                if (first) first.click();
            }
        });
        document.addEventListener('click', function (e) { if (!wrap.contains(e.target)) close(); });

        syncLabel();
    });

    // Admin: drag-and-drop multi-image picker (create/edit product forms)
    document.querySelectorAll('[data-image-dropzone]').forEach(function (zone) {
        var input = zone.querySelector('input[type="file"]');
        var preview = zone.parentElement.querySelector('[data-image-preview]');
        if (!input) return;

        var files = [];

        function render() {
            if (!preview) return;
            preview.innerHTML = '';
            files.forEach(function (file, index) {
                var tile = document.createElement('div');
                tile.className = 'wb-admin__image-tile';

                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                tile.appendChild(img);

                if (index === 0) {
                    var badge = document.createElement('span');
                    badge.className = 'wb-admin__badge wb-admin__image-primary';
                    badge.textContent = 'Primary';
                    tile.appendChild(badge);
                }

                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'wb-admin__icon-btn wb-admin__icon-btn--danger wb-admin__image-remove';
                remove.innerHTML = '&times;';
                remove.addEventListener('click', function () {
                    files.splice(index, 1);
                    sync();
                });
                tile.appendChild(remove);

                preview.appendChild(tile);
            });
        }

        function sync() {
            var transfer = new DataTransfer();
            files.forEach(function (file) { transfer.items.add(file); });
            input.files = transfer.files;
            render();
        }

        function addFiles(fileList) {
            Array.prototype.forEach.call(fileList, function (file) {
                if (file.type.match(/^image\//)) { files.push(file); }
            });
            sync();
        }

        zone.addEventListener('click', function () { input.click(); });
        input.addEventListener('change', function () { addFiles(input.files); });

        ['dragenter', 'dragover'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('is-dragover');
            });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('is-dragover');
            });
        });
        zone.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files) { addFiles(e.dataTransfer.files); }
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
