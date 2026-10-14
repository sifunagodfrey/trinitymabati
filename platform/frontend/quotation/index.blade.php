@extends('frontend.layouts.app')
@section('title', 'Request a Quotation - Trinity Mabati Factory')
@section('content')
<div class="bg-rose-50 min-h-[70vh] py-8" x-data="quotationBuilder()" x-init="init()">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <section class="mb-6 rounded-[4px] border border-gray-200 bg-white px-5 py-8 text-center shadow-sm sm:px-8" style="padding-top: 2rem; padding-bottom: 2rem;" aria-labelledby="quotation-page-title">
      <h1 id="quotation-page-title" class="text-2xl font-medium text-primary sm:text-3xl" style="font-weight: 500;">Request a Quotation</h1>
      <div class="mx-auto my-4 h-px w-20 bg-gray-200" aria-hidden="true"></div>
      <p class="mx-auto max-w-2xl text-sm font-normal text-gray-600 sm:text-base" style="font-weight: 400;">Find your roofing products, adjust the length and quantity, then submit your request.</p>
    </section>
    @if (session('quote_success'))
      <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-5" role="status">
        <strong class="text-emerald-800">Quotation request received!</strong>
        <p class="text-sm text-emerald-800 mt-1">Your reference is <strong>{{ session('quote_success') }}</strong>. Our team will contact you using the details you provided.</p>
      </div>
    @endif
    @if ($errors->any())
      <div class="mb-5 rounded-xl border border-red-300 bg-red-50 p-4 text-sm text-red-700" role="alert">{{ $errors->first() }}</div>
    @endif
    <div x-show="error" x-cloak role="alert" class="mb-5 border border-red-300 bg-red-50 text-red-700 rounded-xl px-4 py-3 text-sm" x-text="error"></div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
      <section class="lg:col-span-6 xl:col-span-7 bg-white rounded-xl border border-gray-200 p-4 sm:p-6 shadow-sm" aria-label="Search and add products">
        <label for="quote-search" class="block text-sm font-semibold text-gray-700 mb-2">Search products</label>
        <div class="relative mb-4"><i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i><input id="quote-search" type="search" x-model="query" @input.debounce.300ms="search()" placeholder="e.g. Corrugated, Tile Red, Eurotile" class="w-full rounded-lg border border-gray-300 py-3 pl-11 pr-3 text-sm focus:border-red-600 focus:ring-red-600"></div>
        <div x-show="loading" class="text-sm text-gray-500 py-5">Searching products…</div>
        <div x-show="!loading && results.length===0" class="text-sm text-gray-500 py-6 text-center">No matching products found.</div>
        <div x-show="!loading" class="space-y-2 max-h-[650px] overflow-y-auto pr-1">
          <template x-for="option in results" :key="option.key">
            <article class="border border-gray-200 rounded-lg p-3 sm:p-4 hover:border-red-300 transition">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="min-w-0 flex-1"><p class="font-semibold text-sm text-gray-900" x-text="option.product_name"></p><p class="text-xs text-gray-600 mt-1" x-text="[option.options, option.length_enabled ? '3 Metres' : ''].filter(Boolean).join(' · ')"></p><p class="text-red-600 font-bold text-sm mt-2" x-text="money(option.unit_price)"></p></div>
                <button type="button" @click="add(option)" :disabled="busy" class="flex-shrink-0 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg px-4 py-2.5 disabled:opacity-50"><i class="fas fa-plus mr-1"></i>Add to quote</button>
              </div>
            </article>
          </template>
        </div>
      </section>
      <section class="lg:col-span-6 xl:col-span-5 bg-white rounded-xl border border-gray-200 p-4 sm:p-6 shadow-sm lg:sticky lg:top-4" aria-label="Selected quotation items">
        <div class="flex justify-between items-center gap-3"><h2 class="font-bold text-lg text-gray-900">Your Quotation</h2><span class="text-xs font-bold bg-red-50 text-red-700 rounded-full px-3 py-1" x-text="items.length + ' items'"></span></div>
        <p class="text-xs text-gray-500 mt-1 mb-4">Change length and quantity for each item before submitting.</p>
        <div x-show="items.length===0" class="border border-dashed border-gray-300 rounded-lg p-7 text-center text-gray-500 text-sm">No products selected yet. Add products from the left.</div>
        <div class="space-y-3 max-h-[510px] overflow-y-auto" x-show="items.length>0">
          <template x-for="item in items" :key="item.key">
            <article class="rounded-lg border border-gray-200 p-3">
              <div class="flex justify-between items-start gap-2"><div><h3 class="text-sm font-bold text-gray-900" x-text="item.product_name"></h3><p class="text-xs text-gray-500 mt-1" x-text="item.options"></p></div><button type="button" @click="remove(item)" aria-label="Remove product" class="text-red-500 p-1 hover:text-red-700"><i class="fas fa-trash"></i></button></div>
              <div class="grid grid-cols-2 gap-3 mt-3">
                <template x-if="item.length_enabled"><div><label class="text-xs font-semibold block mb-1">Metres</label><input type="number" inputmode="decimal" min="0.1" max="30" step="0.01" :value="item.metres" @change="update(item, {metres: $event.target.value})" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></div></template>
                <div><label class="text-xs font-semibold block mb-1">Quantity (sheets)</label><input type="number" min="1" max="10000" step="1" :value="item.quantity" @change="update(item,{quantity:$event.target.value})" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></div>
              </div>
              <div class="flex justify-between items-center mt-3 text-xs"><span class="text-gray-500" x-text="money(item.rate) + (item.length_enabled ? ' per metre' : ' each')"></span><strong class="text-red-600 text-sm" x-text="money(item.unit_price * item.quantity)"></strong></div>
            </article>
          </template>
        </div>
        <div class="border-t border-gray-200 mt-5 pt-4 flex justify-between items-center"><strong class="text-gray-900">Estimated total</strong><strong class="text-red-600 text-xl" x-text="money(total)"></strong></div>
        <p class="text-xs text-gray-500 mt-1 mb-5">Final quotation, availability and applicable charges will be confirmed by our team.</p>
        <form method="POST" action="{{ route('frontend.quotation.submit') }}" @submit="if(!items.length || busy) { $event.preventDefault(); error = 'Add a product before submitting.'; }" class="space-y-3">
          @csrf
          <h3 class="font-bold text-gray-900 text-sm">Your contact details</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3"><div><label class="text-xs font-semibold block mb-1" for="q-first">First name *</label><input id="q-first" name="first_name" required maxlength="100" value="{{ old('first_name') }}" autocomplete="given-name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div><div><label class="text-xs font-semibold block mb-1" for="q-last">Last name *</label><input id="q-last" name="last_name" required maxlength="100" value="{{ old('last_name') }}" autocomplete="family-name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div></div>
          <div><label class="text-xs font-semibold block mb-1" for="q-phone">Phone number *</label><input id="q-phone" type="tel" name="phone" required pattern="[+0-9 ]{9,16}" placeholder="07XX XXX XXX" value="{{ old('phone') }}" autocomplete="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div>
          <div><label class="text-xs font-semibold block mb-1" for="q-email">Email (optional)</label><input id="q-email" type="email" name="email" maxlength="190" placeholder="you@example.com" value="{{ old('email') }}" autocomplete="email" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div>
          <button type="submit" :disabled="busy || items.length===0" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-lg py-3.5 disabled:opacity-50">Submit quotation request <i class="fas fa-arrow-right ml-1"></i></button>
        </form>
      </section>
    </div>
    <div class="mt-8 flex flex-col items-center justify-center gap-3 rounded-[4px] bg-white px-5 py-6 text-center shadow-sm sm:flex-row" aria-label="More ways to get help">
      <p class="text-sm font-medium text-gray-800 sm:mr-3">Need help choosing the right roofing sheets?</p>
      <a href="{{ route('frontend.contact') }}" class="inline-flex w-full items-center justify-center rounded-[4px] border border-primary px-5 py-3 text-sm font-semibold text-primary transition hover:bg-red-50 sm:w-auto">Contact Us</a>
      <a href="{{ route('frontend.products') }}" class="inline-flex w-full items-center justify-center rounded-[4px] bg-primary px-5 py-3 text-sm font-semibold text-white transition hover:opacity-90 sm:w-auto">Browse Products <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i></a>
    </div>
  </div>
</div>
<script>
function quotationBuilder() {
 return {
    query: '', results: [], items: @json($items), loading: false, busy: false, error: '',
    endpoints: {search: @json(route('frontend.quotation.search')), add: @json(route('frontend.quotation.add')), update: @json(route('frontend.quotation.update')), remove: @json(route('frontend.quotation.remove'))},
    get total() { return this.items.reduce((s,i) => s+Number(i.unit_price)*Number(i.quantity), 0); },
    money(n) { return 'KSh ' + Number(n||0).toLocaleString('en-KE',{minimumFractionDigits:2, maximumFractionDigits:2}); },
    init() { this.search(); },
    async search() { this.loading = true; try { const r = await fetch(this.endpoints.search + '?q=' + encodeURIComponent(this.query), {headers:{Accept:'application/json'}}); if(!r.ok)throw new Error('Unable to load products');this.results=(await r.json()).results; }catch(e){this.error=e.message;}finally{this.loading=false;} },
    async request(url,payload) {this.busy=true;this.error='';try {let r=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify(payload)});let data=await r.json();if(!r.ok)throw new Error(Object.values(data.errors||{})[0]?.[0]||data.message||'Could not update quotation');window.location.reload();}catch(e){this.error=e.message;this.busy=false;}},
    add(item) {this.request(this.endpoints.add,{product_id:item.product_id,variant_id:item.variant_id,metres:item.metres,quantity:1});},
    update(item,changes) {this.request(this.endpoints.update,{key:item.key,quantity:item.quantity,metres:item.metres,...changes});},
    remove(item) {this.request(this.endpoints.remove,{key:item.key});}
 };
}
</script>
@endsection
