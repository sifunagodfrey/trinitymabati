@extends('frontend.layouts.app')
@section('title', 'Request a Quotation - Trinity Mabati Factory')
@section('content')
<style>
  .trinity-quote-card { border:1px solid #edf0f3; border-radius:4px; background:#fff; box-shadow:0 2px 8px rgb(20 30 45 / 3%); }
  .trinity-quote-layout { min-width:0; display:grid; grid-template-columns:minmax(0,1fr); gap:20px; align-items:start; }
  .trinity-quote-sidebar { min-width:0; }
  .trinity-quote-sidebar > * + * { margin-top:16px; }
  .trinity-quote-suggestion { border-color:#edf0f3; border-radius:4px; }
  @media (min-width:1024px) {
    .trinity-quote-layout { grid-template-columns:minmax(0,5fr) minmax(0,7fr); }
  }
  .trinity-quote-table-wrap { min-width:0; max-width:100%; }
  .trinity-quote-table { width:100%; min-width:0; border-collapse:collapse; table-layout:fixed; font-size:12px; }
  .trinity-quote-table th { padding:10px 7px; border:1px solid #e8ebee; background:#f5f6f7; color:#25312c; text-align:left; font-weight:600; }
  .trinity-quote-table td { padding:12px 7px; border:1px solid #e8ebee; vertical-align:top; background:#fff; }
  .trinity-quote-table .trinity-quote-image-col { width:44px; }
  .trinity-quote-table .trinity-quote-gauge-col { width:68px; }
  .trinity-quote-table .trinity-quote-length-col { width:88px; }
  .trinity-quote-table .trinity-quote-quantity-col { width:62px; }
  .trinity-quote-table .trinity-quote-price-col { width:92px; }
  .trinity-quote-table .trinity-quote-remove-col { width:34px; }
  .trinity-quote-table img { width:38px; height:48px; object-fit:contain; }
  .trinity-quote-table .trinity-quote-product-name { display:block; margin:0 0 8px; font-size:12px; line-height:1.6; font-weight:500; white-space:normal; overflow-wrap:anywhere; word-break:break-word; }
  .trinity-quote-table label { display:block; margin-top:6px; }
  .trinity-quote-table label > span { display:block; margin-bottom:3px; font-size:11px; color:#647084; }
  .trinity-quote-table input, .trinity-quote-table select { box-sizing:border-box; width:100%; min-width:0; height:36px; padding:6px; border:1px solid #d7dce1; border-radius:4px; background:#fff; color:#25312c; font:400 12px/1.4 var(--font-ui,sans-serif); }
  .trinity-quote-table :is(input,select,button):focus-visible { outline:2px solid var(--primary-color,#bb1c28); outline-offset:2px; }
  .trinity-quote-table :is(input,select,button):disabled { opacity:.5; }
  .trinity-quote-table .trinity-quote-line-price { display:block; white-space:normal; overflow-wrap:anywhere; line-height:1.6; font-weight:500; color:var(--primary-color,#bb1c28); }
  .trinity-quote-table .trinity-quote-remove { display:grid; place-items:center; width:22px; height:22px; padding:0; border:0; border-radius:50%; background:var(--primary-color,#bb1c28); color:#fff; cursor:pointer; font-size:16px; line-height:1; }
  .trinity-quote-search { min-width:0; }
  .trinity-quote-suggestions { max-height:440px; overflow-y:auto; overflow-wrap:anywhere; }
  @media (min-width:1024px) {
    .trinity-quote-search { position:sticky; top:112px; }
    .trinity-quote-suggestions { max-height:calc(100vh - 270px); max-height:calc(100dvh - 270px); }
  }
  @media (max-width:1199px) {
    .trinity-quote-table, .trinity-quote-table tbody { display:block; width:100%; }
    .trinity-quote-table colgroup { display:none; }
    .trinity-quote-table thead { position:absolute; width:1px; height:1px; padding:0; overflow:hidden; clip-path:inset(50%); white-space:nowrap; }
    .trinity-quote-table tbody > tr { display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); gap:12px; padding:12px; margin-top:12px; border:1px solid #e8ebee; border-radius:4px; }
    .trinity-quote-table td { display:block; min-width:0; padding:0; border:0; }
    .trinity-quote-table td[data-label]::before { content:attr(data-label); display:block; margin-bottom:5px; font-size:11px; font-weight:500; color:#647084; }
    .trinity-quote-cell-image { grid-column:1; grid-row:1; }
    .trinity-quote-cell-product { grid-column:2 / 6; grid-row:1; }
    .trinity-quote-cell-remove { grid-column:6; grid-row:1; justify-self:end; }
    .trinity-quote-cell-gauge { grid-column:1 / 4; grid-row:2; }
    .trinity-quote-cell-length { grid-column:4 / 7; grid-row:2; }
    .trinity-quote-cell-quantity { grid-column:1 / 4; grid-row:3; }
    .trinity-quote-cell-price { grid-column:4 / 7; grid-row:3; }
  }
</style>
<div class="bg-rose-50 min-h-[70vh] py-8" x-data="quotationBuilder()">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <section class="mb-6 rounded-[4px] border border-gray-200 bg-white px-5 py-8 text-center shadow-sm sm:px-8" style="padding-top: 2rem; padding-bottom: 2rem;" aria-labelledby="quotation-page-title">
      <h1 id="quotation-page-title" class="text-2xl font-medium text-primary sm:text-3xl" style="font-weight: 500;">Request a Quotation</h1>
      <div class="mx-auto my-4 h-px w-20 bg-gray-200" aria-hidden="true"></div>
      <p class="mx-auto max-w-2xl text-sm font-normal text-gray-600 sm:text-base" style="font-weight: 400;">Find your products, choose the available options, then submit your request.</p>
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
    <div class="trinity-quote-layout">
      <section @click.outside="searchOpen = false" @keydown.escape="searchOpen = false" class="trinity-quote-search trinity-quote-card p-4 sm:p-6" aria-label="Search and add products">
        <label for="quote-search" class="block text-sm font-semibold text-gray-700 mb-2">Search products</label>
        <div class="relative mb-4"><i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i><input id="quote-search" type="search" x-model="query" @focus="openSearch()" @input="scheduleSearch()" aria-controls="quote-suggestions" :aria-expanded="searchOpen.toString()" placeholder="e.g. Corrugated, Tile Red, Eurotile" class="w-full rounded-lg border border-gray-300 py-3 pl-11 pr-3 text-sm focus:border-red-600 focus:ring-red-600"></div>
        <div x-show="searchOpen && loading" class="text-sm text-gray-500 py-5">Searching products…</div>
        <div x-show="searchOpen && !loading && !error && results.length===0" class="text-sm text-gray-500 py-6 text-center">No matching products found.</div>
        <div id="quote-suggestions" x-show="searchOpen && !loading" x-cloak class="trinity-quote-suggestions space-y-2 pr-1" aria-label="Product suggestions" aria-live="polite">
          <template x-for="option in results" :key="option.product_id">
            <button type="button" @click="add(option)" :disabled="busy" class="trinity-quote-suggestion block w-full border p-3 sm:p-4 text-left hover:border-primary hover:bg-red-50 focus-visible:ring-2 focus-visible:ring-primary transition disabled:opacity-50" :aria-label="'Add ' + option.product_name + ' to quotation'">
              <span class="font-medium text-sm text-gray-900" x-text="option.product_name"></span>
            </button>
          </template>
        </div>
      </section>
      <aside class="trinity-quote-sidebar" aria-label="Quotation items, total and contact details">
      <section class="trinity-quote-card p-4 sm:p-6" aria-label="Selected quotation items">
        <div class="flex justify-between items-center gap-3"><h2 class="font-bold text-lg text-gray-900">Your Quotation</h2><span class="text-xs font-bold bg-red-50 text-red-700 rounded-full px-3 py-1" x-text="items.length + (items.length === 1 ? ' item' : ' items')"></span></div>
        <p class="text-xs text-gray-500 mt-1 mb-4">Choose the available options and quantity for each product.</p>
        <div x-show="items.length===0" class="border border-dashed border-gray-300 rounded-lg p-7 text-center text-gray-500 text-sm">No products selected yet. Add products from the left.</div>
        <div class="trinity-quote-table-wrap" x-show="items.length>0">
          <table class="trinity-quote-table" role="table">
            <caption class="sr-only">Quotation products and configurable options</caption>
            <colgroup><col class="trinity-quote-image-col"><col><col class="trinity-quote-gauge-col" x-show="hasGauge"><col class="trinity-quote-length-col"><col class="trinity-quote-quantity-col"><col class="trinity-quote-price-col"><col class="trinity-quote-remove-col"></colgroup>
            <thead><tr><th scope="col">Image</th><th scope="col">Product</th><th scope="col" x-show="hasGauge">Gauge</th><th scope="col">Length (m)</th><th scope="col">Qty</th><th scope="col">Price</th><th scope="col"><span class="sr-only">Remove</span></th></tr></thead>
            <tbody>
              <template x-for="item in items" :key="item.key">
                <tr role="row">
                  <td role="cell" class="trinity-quote-cell-image"><template x-if="item.image_url"><img :src="item.image_url" alt="" loading="lazy"></template><span x-show="!item.image_url" aria-hidden="true">—</span></td>
                  <td role="cell" class="trinity-quote-cell-product">
                    <h3 class="trinity-quote-product-name" x-text="item.product_name"></h3>
                    <template x-for="attribute in extraAttributes(item)" :key="attribute.id">
                      <label><span x-text="attribute.name"></span>
                        <select :disabled="busy" :value="item.selected_attributes[attribute.id] || ''" @change="changeAttribute(item, attribute.id, $event.target.value)">
                          <template x-for="value in attribute.values" :key="value"><option :value="value" x-text="value" :selected="item.selected_attributes[attribute.id] === value"></option></template>
                        </select>
                      </label>
                    </template>
                    <template x-if="!item.configuration.attributes.length && item.configuration.variants.length">
                      <label><span>Option</span>
                        <select :disabled="busy" :value="item.variant_id" @change="update(item, {variant_id: Number($event.target.value)})">
                          <template x-for="variant in item.configuration.variants" :key="variant.id"><option :value="variant.id" x-text="variant.label" :selected="item.variant_id === variant.id"></option></template>
                        </select>
                      </label>
                    </template>
                  </td>
                  <td role="cell" class="trinity-quote-cell-gauge" data-label="Gauge" x-show="hasGauge">
                    <template x-if="gaugeAttribute(item)">
                      <select :disabled="busy" :aria-label="'Gauge for ' + item.product_name" :value="item.selected_attributes[gaugeAttribute(item).id] || ''" @change="changeAttribute(item, gaugeAttribute(item).id, $event.target.value)">
                        <template x-for="value in gaugeAttribute(item).values" :key="value"><option :value="value" x-text="value" :selected="item.selected_attributes[gaugeAttribute(item).id] === value"></option></template>
                      </select>
                    </template>
                    <span x-show="!gaugeAttribute(item)">—</span>
                  </td>
                  <td role="cell" class="trinity-quote-cell-length" data-label="Length (m)">
                    <template x-if="item.length_enabled">
                      <div>
                        <select :disabled="busy" :aria-label="'Length in metres for ' + item.product_name" :value="item.editing_length ? 'custom' : (item.length_mode === 'custom' ? 'saved' : item.length_mode)" @change="selectLength(item, $event.target.value); if (item.editing_length) $nextTick(() => $event.target.parentElement.querySelector('input').focus())">
                          <option value="1">1 m</option><option value="2">2 m</option><option value="3">3 m</option>
                          <template x-if="![1, 2, 3].includes(Number(item.metres))"><option value="saved" x-text="Number(item.metres) + ' m'" :selected="!item.editing_length && item.length_mode === 'custom'"></option></template>
                          <option value="custom" :selected="item.editing_length">Custom</option>
                        </select>
                        <label x-show="item.editing_length">
                          <input :disabled="busy" :aria-label="'Custom length in metres for ' + item.product_name" type="number" inputmode="decimal" min="0.10" max="30" step="0.01" x-model="item.draft_metres" @input="if (Number($event.target.value) > 30) { item.draft_metres = '30'; $event.target.value = '30'; } item.length_dirty = true" @input.debounce.500ms="updateCustom(item)" :aria-invalid="!validLength(item.draft_metres)">
                        </label>
                        <p x-show="item.editing_length && !validLength(item.draft_metres)" class="text-xs text-red-600 mt-1">0.10–30 m, up to 2 decimals.</p>
                      </div>
                    </template>
                    <span x-show="!item.length_enabled" aria-label="Fixed size">—</span>
                  </td>
                  <td role="cell" class="trinity-quote-cell-quantity" data-label="Quantity"><input :disabled="busy" :aria-label="'Quantity for ' + item.product_name" type="number" min="1" max="10000" step="1" x-model="item.draft_quantity" @input="item.quantity_dirty = true" @change="update(item, {quantity: item.draft_quantity})"></td>
                  <td role="cell" class="trinity-quote-cell-price" data-label="Price"><span class="trinity-quote-line-price" x-text="money(item.unit_price * item.quantity)"></span></td>
                  <td role="cell" class="trinity-quote-cell-remove"><button type="button" class="trinity-quote-remove" :disabled="busy" @click="remove(item)" :aria-label="'Remove ' + item.product_name"><span aria-hidden="true">×</span></button></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </section>
      <section class="trinity-quote-card p-4 sm:p-6" aria-label="Estimated total">
        <div class="flex justify-between items-center gap-3"><strong class="text-gray-900">Estimated total</strong><strong class="text-red-600 text-xl" x-text="money(total)"></strong></div>
        <p class="text-xs text-gray-500 mt-2">Final quotation, availability and applicable charges will be confirmed by our team.</p>
      </section>
      <section class="trinity-quote-card p-4 sm:p-6" aria-label="Your contact details">
        <form method="POST" action="{{ route('frontend.quotation.submit') }}" @submit="if(!items.length || busy || hasPendingOptions) { $event.preventDefault(); error = 'Add a product and finish saving valid options before submitting.'; }" class="space-y-3">
          @csrf
          <h3 class="font-bold text-gray-900 text-sm">Your contact details</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3"><div><label class="text-xs font-semibold block mb-1" for="q-first">First name *</label><input id="q-first" name="first_name" required maxlength="100" value="{{ old('first_name') }}" autocomplete="given-name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div><div><label class="text-xs font-semibold block mb-1" for="q-last">Last name (optional)</label><input id="q-last" name="last_name" maxlength="100" value="{{ old('last_name') }}" autocomplete="family-name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div></div>
          <div><label class="text-xs font-semibold block mb-1" for="q-phone">Phone number *</label><input id="q-phone" type="tel" name="phone" required pattern="[+0-9 ]{9,16}" placeholder="07XX XXX XXX" value="{{ old('phone') }}" autocomplete="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div>
          <div><label class="text-xs font-semibold block mb-1" for="q-email">Email (optional)</label><input id="q-email" type="email" name="email" maxlength="190" placeholder="you@example.com" value="{{ old('email') }}" autocomplete="email" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm"></div>
          <button type="submit" :disabled="busy || hasPendingOptions || items.length===0" class="w-full bg-primary transition hover:opacity-90 text-white font-bold text-sm rounded-lg py-3.5 disabled:opacity-50">Submit quotation request <i class="fas fa-arrow-right ml-1"></i></button>
        </form>
      </section>
      </aside>
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
    query: '', results: [], searchOpen: false, searchTimer: null, searchController: null, searchVersion: 0, customTimer: null,
    items: @json($items), loading: false, busy: false, error: '',
    endpoints: {search: @json(route('frontend.quotation.search')), add: @json(route('frontend.quotation.add')), update: @json(route('frontend.quotation.update')), remove: @json(route('frontend.quotation.remove'))},
    get total() { return this.items.reduce((sum, item) => sum + Number(item.unit_price) * Number(item.quantity), 0); },
    get hasPendingOptions() { return this.items.some(item => item.quantity_dirty || (item.length_enabled && item.length_mode === 'custom' && (item.length_dirty || !this.validLength(item.draft_metres)))); },
    money(n) { return 'KSh ' + Number(n || 0).toLocaleString('en-KE', {minimumFractionDigits: 2, maximumFractionDigits: 2}); },
    prepare(items) {
      return items.map(item => ({...item, configuration: item.configuration || {attributes: [], variants: []}, selected_attributes: item.selected_attributes || {},
        length_mode: [1, 2, 3].includes(Number(item.metres)) ? String(Number(item.metres)) : 'custom', draft_metres: item.metres == null ? '' : String(item.metres), length_dirty: false, editing_length: false, draft_quantity: String(item.quantity), quantity_dirty: false}));
    },
    init() { this.items = this.prepare(this.items); },
    gaugeAttribute(item) { return item.configuration.attributes.find(attribute => String(attribute.name).trim().toLowerCase() === 'gauge') || null; },
    get hasGauge() { return this.items.some(item => this.gaugeAttribute(item)); },
    extraAttributes(item) { return this.visibleAttributes(item).filter(attribute => String(attribute.name).trim().toLowerCase() !== 'gauge'); },
    visibleAttributes(item) {
      return item.configuration.attributes.filter(attribute => {
        const name = String(attribute.name).trim().toLowerCase();
        return !['color', 'colour'].includes(name) && !(name === 'finish' && attribute.values.length <= 1);
      });
    },
    visibleOptions(item) {
      return this.visibleAttributes(item).map(attribute => {
        const value = item.selected_attributes[attribute.id];
        return value ? attribute.name + ' ' + value : '';
      }).filter(Boolean).join(' · ');
    },
    validLength(value) { return /^(?:\d+)(?:\.\d{1,2})?$/.test(String(value)) && Number(value) >= 0.1 && Number(value) <= 30; },
    openSearch() { this.searchOpen = true; if (!this.results.length && !this.loading) this.scheduleSearch(0); },
    scheduleSearch(delay = 250) {
      clearTimeout(this.searchTimer); this.searchController?.abort();
      const version = ++this.searchVersion;
      this.searchOpen = true; this.results = []; this.error = ''; this.loading = true;
      this.searchTimer = setTimeout(() => this.search(version), delay);
    },
    async search(version = ++this.searchVersion) {
      const controller = new AbortController(); this.searchController = controller; this.loading = true;
      try {
        const response = await fetch(this.endpoints.search + '?q=' + encodeURIComponent(this.query.trim()), {signal: controller.signal, headers: {Accept: 'application/json'}});
        if (!response.ok) throw new Error('Unable to load products. Please try again.');
        const data = await response.json();
        if (version === this.searchVersion) this.results = Array.isArray(data.results) ? data.results.slice(0, 8) : [];
      } catch (error) {
        if (error.name !== 'AbortError' && version === this.searchVersion) this.error = error.message;
      } finally { if (version === this.searchVersion) this.loading = false; }
    },
    destroy() { clearTimeout(this.customTimer); clearTimeout(this.searchTimer); this.searchController?.abort(); },
    async request(url, payload) {
      if (this.busy) return false;
      this.busy = true; this.error = '';
      try {
        const response = await fetch(url, {method: 'POST', headers: {'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, body: JSON.stringify(payload)});
        const data = await response.json();
        if (!response.ok) throw new Error(Object.values(data.errors || {})[0]?.[0] || data.message || 'Could not update quotation');
        if (!Array.isArray(data.items)) throw new Error('Unable to refresh quotation. Please reload the page.');
        const drafts = new Map(this.items.filter(item => item.key !== payload.key && (item.length_dirty || item.quantity_dirty)).map(item => [item.key, item]));
        this.items = this.prepare(data.items).map(item => {
          const draft = drafts.get(item.key);
          return draft ? {...item, length_mode: draft.length_mode, draft_metres: draft.draft_metres, length_dirty: draft.length_dirty, editing_length: draft.editing_length, draft_quantity: draft.draft_quantity, quantity_dirty: draft.quantity_dirty} : item;
        });
        return true;
      } catch (error) { this.error = error.message; return false; }
      finally { this.busy = false; }
    },
    add(option) { return this.request(this.endpoints.add, {product_id: option.product_id, variant_id: option.variant_id, metres: option.metres, quantity: 1}); },
    async update(item, changes) {
      const quantity = Number(changes.quantity ?? item.draft_quantity ?? item.quantity);
      if (!Number.isInteger(quantity) || quantity < 1 || quantity > 10000) { this.error = 'Quantity must be a whole number from 1 to 10,000.'; return false; }
      const metres = changes.metres ?? (item.length_enabled && item.length_mode === 'custom' ? item.draft_metres : item.metres);
      if (item.length_enabled && !this.validLength(metres)) { this.error = 'Enter a valid length from 0.10 to 30 metres.'; return false; }
      return this.request(this.endpoints.update, {key: item.key, variant_id: item.variant_id, ...changes, quantity, metres});
    },
    selectLength(item, value) {
      if (value === 'custom') {
        item.editing_length = true;
        item.length_mode = 'custom';
        item.draft_metres = String(item.metres);
        item.length_dirty = false;
        return;
      }
      item.editing_length = false;
      item.length_dirty = false;
      if (value === 'saved') { item.length_mode = 'custom'; return; }
      item.length_mode = value;
      return this.update(item, {metres: value});
    },
    updateCustom(item) { if (item.length_mode !== 'custom' || !item.length_dirty || !this.validLength(item.draft_metres)) return; const current = this.items.find(entry => entry.key === item.key); if (!current) return; if (this.busy) { this.customTimer = setTimeout(() => this.updateCustom(current), 250); return; } return this.update(current, {metres: current.draft_metres}); },
    async changeAttribute(item, attributeId, value) {
      const desired = {...item.selected_attributes, [attributeId]: value};
      // Keep the other selections wherever possible; always use a real variant.
      const candidates = item.configuration.variants.filter(variant => variant.attributes[attributeId] === value);
      candidates.sort((a, b) => {
        const score = variant => Object.entries(desired).filter(([id, selected]) => variant.attributes[id] === selected).length;
        return score(b) - score(a);
      });
      if (!candidates.length) { this.error = 'This product option is unavailable.'; return; }
      return this.update(item, {variant_id: candidates[0].id});
    },
    remove(item) { return this.request(this.endpoints.remove, {key: item.key}); }
 };
}
</script>
@endsection
