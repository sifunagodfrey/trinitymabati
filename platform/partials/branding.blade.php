<style id="site-branding">
    :root {
        --primary-color: {{ $branding['primary_color'] }};
        --primary-dark: color-mix(in srgb, var(--primary-color) 80%, black);
        --primary-light: color-mix(in srgb, var(--primary-color) 12%, white);
        --secondary-color: {{ $branding['secondary_color'] }};
        --secondary-dark: color-mix(in srgb, var(--secondary-color) 80%, black);
        --secondary-light: color-mix(in srgb, var(--secondary-color) 12%, white);
        --tertiary-color: {{ $branding['tertiary_color'] }};
        --tertiary-dark: color-mix(in srgb, var(--tertiary-color) 80%, black);
        --tertiary-light: color-mix(in srgb, var(--tertiary-color) 12%, white);
        --footer-color: var(--tertiary-color);
        --background-color: color-mix(in srgb, var(--primary-color) 4%, white);
        --band-grey: color-mix(in srgb, var(--primary-color) 7%, white);
    }
</style>
