@props(['active' => false])

@php
    $classes = $active
        ? 'block w-full border-l-4 border-primary bg-primary/5 py-2 pl-3 pr-4 text-left text-base font-medium text-primary focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full border-l-4 border-transparent py-2 pl-3 pr-4 text-left text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-primary focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'aria-current' => $active ? 'page' : null]) }}>{{ $slot }}</a>
