@props(['active' => false])

@php
    $classes = $active
        ? 'inline-flex items-center border-b-2 border-primary px-1 pt-1 text-sm font-medium leading-5 text-primary focus:outline-none transition duration-150 ease-in-out'
        : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-600 hover:border-gray-300 hover:text-primary focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'aria-current' => $active ? 'page' : null]) }}>{{ $slot }}</a>
