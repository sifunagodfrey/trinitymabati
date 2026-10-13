{{-- ---------------
-- Reusable searchable multi-select. Props:
--   name        - form field name, posts as `{{ $name }}[]`
--   label       - field label text
--   options     - array of ['id' => ..., 'name' => ...]
--   selected    - array of currently selected ids
--   placeholder - search input placeholder
--   errorKey    - validation error key (defaults to $name)
-- --------------- --}}
@php
    $errorKey = $errorKey ?? $name;
    $fieldId  = 'ss-' . preg_replace('/[^a-zA-Z0-9]+/', '-', $name);
@endphp
<div class="space-y-2 search-select" data-name="{{ $name }}" data-field="{{ $fieldId }}">
    <label class="block text-sm font-medium text-text">{{ $label }}</label>

    <div id="{{ $fieldId }}-chips" class="flex flex-wrap gap-2"></div>

    <div class="relative">
        <input type="text" id="{{ $fieldId }}-search" autocomplete="off"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-[8px] border border-border bg-background px-4 py-3 text-sm font-normal text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
        <div id="{{ $fieldId }}-dropdown"
            class="hidden absolute z-10 mt-1 max-h-48 w-full overflow-y-auto rounded-[8px] border border-border bg-background shadow-lg"></div>
    </div>

    <div id="{{ $fieldId }}-inputs"></div>

    <script type="application/json" data-role="options">{!! json_encode($options) !!}</script>
    <script type="application/json" data-role="selected">{!! json_encode($selected) !!}</script>

    @error($errorKey)<p class="text-sm text-red-500">{{ $message }}</p>@enderror
</div>

@once
    @push('scripts')
    <script>
    // ---------------
    // Reusable Searchable Multi-Select - vanilla JS, no dependencies.
    // Initializes every .search-select block on the page from its embedded
    // JSON options/selected data. Renders chips + hidden `name[]` inputs.
    // ---------------
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.search-select').forEach(function (root) {
            const fieldId   = root.dataset.field;
            const fieldName = root.dataset.name;
            const options   = JSON.parse(root.querySelector('script[data-role="options"]').textContent);
            const initial   = JSON.parse(root.querySelector('script[data-role="selected"]').textContent).map(Number);

            const chipsEl    = document.getElementById(fieldId + '-chips');
            const searchEl   = document.getElementById(fieldId + '-search');
            const dropdownEl = document.getElementById(fieldId + '-dropdown');
            const inputsEl   = document.getElementById(fieldId + '-inputs');

            let selected = [...initial];

            function optionById(id) {
                return options.find(function (o) { return o.id === id; });
            }

            function renderDropdown() {
                const term    = searchEl.value.trim().toLowerCase();
                const matches = options.filter(function (o) {
                    return !selected.includes(o.id) && o.name.toLowerCase().includes(term);
                });

                dropdownEl.innerHTML = '';
                if (!matches.length) {
                    const empty = document.createElement('p');
                    empty.className   = 'px-4 py-2 text-sm font-normal text-muted';
                    empty.textContent = 'No matches';
                    dropdownEl.appendChild(empty);
                    return;
                }
                matches.forEach(function (opt) {
                    const item = document.createElement('div');
                    item.className   = 'cursor-pointer px-4 py-2 text-sm font-normal text-text hover:bg-primary-light';
                    item.textContent = opt.name;
                    item.addEventListener('click', function (e) {
                        e.stopPropagation();
                        selected.push(opt.id);
                        searchEl.value = '';
                        render();
                        searchEl.focus();
                    });
                    dropdownEl.appendChild(item);
                });
            }

            function render() {
                chipsEl.innerHTML  = '';
                inputsEl.innerHTML = '';

                selected.forEach(function (id) {
                    const opt = optionById(id);
                    if (!opt) return;

                    const chip = document.createElement('span');
                    chip.className = 'inline-flex items-center gap-1.5 rounded-[8px] border border-border bg-background px-3 py-1 text-sm font-normal text-text';

                    const label = document.createElement('span');
                    label.className   = 'font-normal';
                    label.textContent = opt.name;
                    chip.appendChild(label);

                    const removeBtn = document.createElement('button');
                    removeBtn.type      = 'button';
                    removeBtn.className = 'text-muted hover:text-red-500';
                    removeBtn.innerHTML = '<i class="fa-solid fa-xmark text-xs"></i>';
                    removeBtn.addEventListener('click', function () {
                        selected = selected.filter(function (i) { return i !== id; });
                        render();
                    });
                    chip.appendChild(removeBtn);
                    chipsEl.appendChild(chip);

                    const input = document.createElement('input');
                    input.type  = 'hidden';
                    input.name  = fieldName + '[]';
                    input.value = id;
                    inputsEl.appendChild(input);
                });

                renderDropdown();
            }

            searchEl.addEventListener('focus', function () {
                dropdownEl.classList.remove('hidden');
                renderDropdown();
            });
            searchEl.addEventListener('input', renderDropdown);
            document.addEventListener('click', function (e) {
                if (!root.contains(e.target)) dropdownEl.classList.add('hidden');
            });

            render();
        });
    });
    </script>
    @endpush
@endonce