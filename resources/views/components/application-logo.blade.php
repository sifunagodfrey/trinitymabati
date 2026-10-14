@props(['class' => 'h-9 w-auto'])
@php
    $logo = $branding['logo_main'] ?? null;
@endphp
@if ($logo)
    <img src="{{ $logo }}" alt="{{ config('app.name', 'Trinity Mabati Factory') }}" {{ $attributes->merge(['class' => $class]) }}>
@else
    <span {{ $attributes->merge(['class' => 'font-bold text-gray-900']) }}>Trinity Mabati Factory</span>
@endif
