<dl class="grid gap-3 text-sm sm:grid-cols-2">
    @if(!empty($details['bank_name']))<div><dt class="text-gray-500">Bank</dt><dd class="mt-1 font-semibold text-gray-900">{{ $details['bank_name'] }}</dd></div>@endif
    <div><dt class="text-gray-500">M-Pesa Paybill</dt><dd class="mt-1 font-semibold text-primary">{{ $details['paybill'] ?? '' }}</dd></div>
    <div><dt class="text-gray-500">Account / reference number</dt><dd class="mt-1 break-all font-semibold text-gray-900">{{ $details['account_number'] ?? '' }}</dd></div>
    <div><dt class="text-gray-500">Account name</dt><dd class="mt-1 font-semibold text-gray-900">{{ $details['account_name'] ?? '' }}</dd></div>
</dl>
@if(!empty($details['instructions']))<p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-gray-600">{{ $details['instructions'] }}</p>@endif
