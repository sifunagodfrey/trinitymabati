{{-- -------------------
     Text Input Component
------------------- --}}
@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary rounded-[8px] shadow-sm']) }}>
