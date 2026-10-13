<?php

namespace App\Http\Controllers\Manage\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Shipping\StoreLocationPricingRequest;
use App\Models\Manage\Shipping\LocationPricing;
use App\Models\Manage\Shipping\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    // ---------------
    // List location pricing with filters and pagination
    // location_name and county_name are aliased from the joined
    // su_towns and su_counties tables so the view stays unchanged
    // ---------------
    public function index(Request $request)
    {
        $counties = DB::table('su_counties')->orderBy('name')->get();

        $sortOrder = $request->get('sort', 'asc') === 'desc' ? 'desc' : 'asc';

        $query = LocationPricing::query()
            ->select(
                'su_location_pricing.*',
                'su_towns.name as location_name',
                'su_counties.id as county_id',
                'su_counties.name as county_name'
            )
            ->join('su_towns', 'su_location_pricing.town_id', '=', 'su_towns.id')
            ->join('su_counties', 'su_towns.county_id', '=', 'su_counties.id');

        if ($request->filled('county')) {
            $query->where('su_counties.id', $request->county);
        }

        if ($request->filled('search')) {
            $query->where('su_towns.name', 'like', '%' . $request->search . '%');
        }

        $query->orderBy('su_towns.name', $sortOrder);

        $pricingEntries = $query->paginate(10)->withQueryString();

        return view('manage.shipping.pricing.index', compact('counties', 'pricingEntries', 'sortOrder'));
    }

    // ---------------
    // Save new location pricing entry.
    // The admin still just picks a county and types a location name,
    // the matching town is found or created behind the scenes, then
    // priced. A county's town keeps a single price, so re-submitting
    // an existing town's name updates its price instead of duplicating it.
    // ---------------
    public function store(StoreLocationPricingRequest $request)
    {
        $data = $request->validated();

        $town = Town::firstOrCreate(
            [
                'county_id' => $data['county_id'],
                'name'      => $data['location_name'],
            ]
        );

        LocationPricing::updateOrCreate(
            ['town_id' => $town->id],
            [
                'price'                   => $data['price'],
                'distance_km'             => $data['distance'] ?? null,
                'estimated_delivery_days' => $data['estimated_delivery'] ?? null,
            ]
        );

        return redirect()->route('manage.shipping.pricing.index')
            ->with('success', 'Delivery location pricing added successfully.');
    }

    // ---------------
    // Delete a pricing entry (the town itself stays, only its price is removed)
    // ---------------
    public function destroy(string $id)
    {
        LocationPricing::findOrFail($id)->delete();

        return redirect()->route('manage.shipping.pricing.index')
            ->with('success', 'Pricing entry deleted.');
    }
}
