<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\System\SystemMessage;
use App\Models\User;
use App\Services\RecordPurger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CustomersController extends Controller
{
    // ---------------
    // List users with the 'client' role, with search and status filter
    // ---------------
    public function index(): View
    {
        $query = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name',  'like', "%{$search}%")
                      ->orWhere('email',       'like', "%{$search}%");
                });
            })
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $customers = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.customers.index', compact('customers'));
    }

    // ---------------
    // Customer detail - profile info, recent orders, message history
    // ---------------
    public function show(string $id): View
    {
        $customer = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->with('profile')
            ->findOrFail($id);

        $orders = Order::where('user_id', $id)->latest()->limit(10)->get();

        $messages = SystemMessage::where(function ($q) use ($id) {
            $q->where('sender_id', $id)->orWhere('recipient_id', $id);
        })->latest()->limit(15)->get();

        return view('manage.ecommerce.customers.show', compact('customer', 'orders', 'messages'));
    }

    // ---------------
    // Show message compose form with history for a customer
    // ---------------
    public function message(string $id): View
    {
        $customer = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->findOrFail($id);

        $adminId = auth()->id();

        $messages = SystemMessage::where(function ($q) use ($adminId, $id) {
            $q->where(fn ($q) => $q->where('sender_id', $adminId)->where('recipient_id', $id))
              ->orWhere(fn ($q) => $q->where('sender_id', $id)->where('recipient_id', $adminId));
        })->latest()->limit(10)->get();

        return view('manage.ecommerce.customers.message', compact('customer', 'messages'));
    }

    // ---------------
    // Send a message to a customer and store in su_system_messages
    // ---------------
    public function sendMessage(Request $request, string $id): RedirectResponse
    {
        $customer = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SystemMessage::create([
            'sender_id'    => auth()->id(),
            'recipient_id' => $customer->id,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'is_read'      => false,
            'is_user_read' => false,
        ]);

        return redirect()->route('manage.ecommerce.customers.message', $id)
            ->with('success', 'Message sent to ' . $customer->first_name . ' successfully.');
    }

    // ---------------
    // Toggle customer status between active and suspended
    // ---------------
    public function toggleStatus(string $id): RedirectResponse
    {
        $customer = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->findOrFail($id);

        $newStatus = $customer->status === 'active' ? 'suspended' : 'active';
        $customer->update(['status' => $newStatus]);

        return redirect()->route('manage.ecommerce.customers.show', $id)
            ->with('success', 'Customer status changed to ' . ucfirst($newStatus) . '.');
    }

    // ---------------
    // Permanently delete one customer plus their orders, quotations and other data
    // ---------------
    public function destroy(string $id, RecordPurger $purger): RedirectResponse
    {
        $customer = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->findOrFail($id);

        $name = trim($customer->first_name . ' ' . $customer->last_name);

        try {
            $purger->purgeCustomers([$customer->id]);
        } catch (\Throwable $e) {
            Log::error('Customer delete failed', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('manage.ecommerce.customers.show', $id)
                ->with('error', 'Could not delete this customer: ' . $e->getMessage());
        }

        return redirect()->route('manage.ecommerce.customers.index')
            ->with('success', 'Customer ' . $name . ' and all their data were deleted.');
    }

    // ---------------
    // Permanently delete the selected customers
    // ---------------
    public function bulkDestroy(Request $request, RecordPurger $purger): RedirectResponse
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        // Only genuine customer accounts - never staff
        $ids = User::whereHas('role', fn ($q) => $q->where('slug', 'customer'))
            ->whereIn('id', $data['ids'])
            ->pluck('id')
            ->all();

        try {
            $count = $purger->purgeCustomers($ids);
        } catch (\Throwable $e) {
            Log::error('Bulk customer delete failed', ['error' => $e->getMessage()]);

            return back()->with('error', 'Could not delete the selected customers: ' . $e->getMessage());
        }

        return redirect()->route('manage.ecommerce.customers.index')
            ->with('success', $count . ' customer(s) and their data were deleted.');
    }
}
