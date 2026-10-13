<?php

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Settings\StoreVatRequest;
use App\Models\Manage\System\SystemMessage;
use App\Models\Manage\System\Vat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VatController extends Controller
{
    // ---------------
    // Show VAT Settings and History
    // ---------------
    public function index()
    {
        $activeVat  = Vat::where('is_active', 1)->orderByDesc('id')->first();
        $vatHistory = Vat::orderByDesc('id')->get();

        return view('manage.settings.vat.index', compact('activeVat', 'vatHistory'));
    }

    // ---------------
    // Save New VAT Rate
    // ---------------
    public function store(StoreVatRequest $request)
    {
        $user    = Auth::user();
        $oldRate = Vat::where('is_active', 1)->orderByDesc('id')->value('rate') ?? 0;

        DB::transaction(function () use ($request) {
            Vat::where('is_active', 1)->update(['is_active' => 0]);
            Vat::create([
                'rate'       => $request->vat_rate,
                'start_date' => now()->toDateString(),
                'is_active'  => 1,
            ]);
        });

        SystemMessage::create([
            'sender_id'    => $user->id,
            'recipient_id' => null,
            'subject'      => 'VAT Rate Updated',
            'message'      => sprintf(
                '%s (User ID %d) changed the active VAT rate from %.2f%% to %.2f%%.',
                $user->name,
                $user->id,
                $oldRate,
                $request->vat_rate
            ),
            'related_url'  => route('manage.settings.vat.index'),
            'is_read'      => 0,
            'is_user_read' => 0,
        ]);

        return redirect()->route('manage.settings.vat.index')
            ->with('success', 'VAT rate updated successfully.');
    }

    // ---------------
    // Apply a Historical VAT Rate as Active
    // ---------------
    public function apply(string $id)
    {
        $user    = Auth::user();
        $target  = Vat::findOrFail($id);
        $oldRate = Vat::where('is_active', 1)->orderByDesc('id')->value('rate') ?? 0;

        DB::transaction(function () use ($target) {
            Vat::where('is_active', 1)->update(['is_active' => 0]);
            $target->update(['is_active' => 1]);
        });

        SystemMessage::create([
            'sender_id'    => $user->id,
            'recipient_id' => null,
            'subject'      => 'VAT Rate Changed',
            'message'      => sprintf(
                '%s (User ID %d) changed the active VAT rate from %.2f%% to %.2f%%.',
                $user->name,
                $user->id,
                $oldRate,
                $target->rate
            ),
            'related_url'  => route('manage.settings.vat.index'),
            'is_read'      => 0,
            'is_user_read' => 0,
        ]);

        return redirect()->route('manage.settings.vat.index')
            ->with('success', 'VAT rate applied successfully.');
    }
}
