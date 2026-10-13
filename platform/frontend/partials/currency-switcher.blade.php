{{-- ---------------
-- Currency Switcher
-- Reads $activeCurrency and $availableCurrencies from the view composer
-- --------------- --}}
<div x-data="{ open: false }" class="relative" @click.away="open = false">

    {{-- ---------------
    -- Trigger Button
    -- --------------- --}}
    <button @click="open = !open"
        class="flex items-center gap-1 hover:opacity-80 transition font-semibold text-sm"
        aria-haspopup="listbox" :aria-expanded="open">
        {{ $activeCurrency }}
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="open ? 'rotate-180' : ''"></i>
    </button>

    {{-- ---------------
    -- Dropdown
    -- --------------- --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="absolute left-0 mt-2 w-32 bg-white text-gray-800 rounded-[8px] shadow-lg py-1 z-50 text-xs border border-gray-100"
        role="listbox">

        @foreach ($availableCurrencies as $c)
            <form method="POST" action="{{ route('frontend.currency.switch') }}">
                @csrf
                <input type="hidden" name="currency" value="{{ $c['code'] }}">
                <button type="submit" role="option"
                    class="flex items-center justify-between w-full text-left px-3 py-2 transition
                        {{ $activeCurrency === $c['code']
                            ? 'bg-primary/5 font-bold text-primary'
                            : 'text-gray-700 hover:bg-gray-50' }}"
                    @if ($activeCurrency === $c['code']) aria-selected="true" @endif>
                    <span>{{ $c['code'] }}</span>
                    <span class="text-gray-400 font-normal">{{ $c['symbol'] }}</span>
                </button>
            </form>
        @endforeach

    </div>

</div>
