<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreAddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    // ---------------
    // Current Delivery Address
    // ---------------
    public function index()
    {
        $raw = DB::table('su_user_profiles')
            ->where('user_id', Auth::id())
            ->first(['county_id', 'town_id']);

        // ---------------
        // Resolve names for display; keep the same $profile->county /
        // $profile->delivery_location shape so the view needs no changes.
        // ---------------
        $profile = null;

        if ($raw?->county_id) {
            $profile = (object) [
                'county' => DB::table('su_counties')->where('id', $raw->county_id)->value('name'),
                'delivery_location' => $raw->town_id
                    ? DB::table('su_towns')->where('id', $raw->town_id)->value('name')
                    : null,
            ];
        }

        return view('client.address.index', compact('profile'));
    }

    // ---------------
    // Set / Update Address Form
    // ---------------
    public function create()
    {
        $counties = DB::table('su_counties')->orderBy('name')->get(['id', 'name']);

        // su_user_profiles already stores the real IDs, no reverse lookup needed
        $profile = DB::table('su_user_profiles')
            ->where('user_id', Auth::id())
            ->first(['county_id', 'town_id']);

        return view('client.address.create', [
            'counties'          => $counties,
            'currentCountyId'   => $profile?->county_id,
            'currentLocationId' => $profile?->town_id,
        ]);
    }

    // ---------------
    // Save Delivery Address (upsert)
    // ---------------
    public function store(StoreAddressRequest $request)
    {
        $data = [
            'county_id'  => $request->integer('county_id'),
            'town_id'    => $request->integer('location_id'),
            'updated_at' => now(),
        ];

        $affected = DB::table('su_user_profiles')
            ->where('user_id', Auth::id())
            ->update($data);

        if ($affected === 0) {
            // id is AUTO_INCREMENT - let the DB assign it
            DB::table('su_user_profiles')->insert(array_merge($data, [
                'user_id'    => Auth::id(),
                'created_at' => now(),
            ]));
        }

        return redirect()->route('client.address.index')
            ->with('success', 'Delivery address saved successfully.');
    }

    // ---------------
    // AJAX - Towns (delivery locations) for a County
    // Aliased to the same field names the checkout page's JS expects
    // ---------------
    public function locations(Request $request)
    {
        $request->validate(['county_id' => 'required|integer|exists:su_counties,id']);

        $locations = DB::table('su_towns')
            ->leftJoin('su_location_pricing', 'su_location_pricing.town_id', '=', 'su_towns.id')
            ->where('su_towns.county_id', $request->integer('county_id'))
            ->orderBy('su_towns.name')
            ->get([
                'su_towns.id',
                'su_towns.name as location_name',
                'su_location_pricing.price',
                'su_location_pricing.estimated_delivery_days as estimated_delivery',
            ]);

        return response()->json($locations);
    }
}