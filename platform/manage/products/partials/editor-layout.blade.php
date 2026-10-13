@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById(@json($formId));
    if (!form || form.dataset.editorLayoutReady) return;
    form.dataset.editorLayoutReady = '1';

    const sections = Array.from(form.children).filter((node) => node.tagName === 'DIV');
    const classification = sections.find((node) => node.querySelector('#category_id'));
    const media = sections.find((node) => node.querySelector('#thumbnail'));
    const publishing = sections.find((node) => node.querySelector('button[type="submit"]'));

    const layout = document.createElement('div');
    layout.className = 'product-editor-layout';
    const main = document.createElement('div');
    main.className = 'product-editor-main';
    const sidebar = document.createElement('aside');
    sidebar.className = 'product-editor-sidebar';
    layout.append(main, sidebar);
    form.appendChild(layout);

    sections.forEach((section) => {
        section.classList.add('product-editor-card');
        if ([classification, media, publishing].includes(section)) {
            sidebar.appendChild(section);
        } else {
            main.appendChild(section);
        }
    });

    if (classification) {
        classification.classList.remove('lg:grid-cols-3');
        classification.classList.add('grid-cols-1');
        classification.insertAdjacentHTML('afterbegin', '<div class="product-editor-card-title"><i class="fa-solid fa-layer-group"></i><span>Classification</span></div>');
    }
    if (media) {
        media.classList.remove('lg:grid-cols-2');
        media.classList.add('grid-cols-1');
        media.insertAdjacentHTML('afterbegin', '<div class="product-editor-card-title"><i class="fa-regular fa-images"></i><span>Product media</span></div>');
    }
    if (publishing) {
        publishing.classList.remove('sm:flex-row', 'sm:justify-end', 'justify-end', 'border-t', 'pt-4', 'pt-6');
        publishing.classList.add('flex-col', 'items-stretch');
        publishing.insertAdjacentHTML('afterbegin', '<div class="product-editor-card-title"><i class="fa-solid fa-paper-plane"></i><span>Publish</span></div>');
        publishing.querySelectorAll('a, button').forEach((element) => element.classList.add('w-full', 'justify-center'));
    }
});
</script>
@endpush
