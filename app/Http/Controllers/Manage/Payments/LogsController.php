<?php

namespace App\Http\Controllers\Manage\Payments;

use App\Http\Controllers\Controller;
use App\Models\Manage\Payments\PaymentLog;

class LogsController extends Controller
{
    public function index()
    {
        $logs = PaymentLog::with('payment')
            ->orderBy('id', 'desc')
            ->paginate(20);

        // Add virtual attributes for the view (no DB columns needed)
        $logs->getCollection()->transform(function ($log) {
            $log->event_type = 'Payment callback';
            $log->source = 'M-Pesa';
            $log->message = $this->getMessageFromResponse($log->gateway_response, $log->status);
            return $log;
        });

        return view('manage.payments.logs.index', compact('logs'));
    }

    protected function getMessageFromResponse($response, $status)
    {
        if (is_array($response) && isset($response['Body']['stkCallback']['ResultDesc'])) {
            return $response['Body']['stkCallback']['ResultDesc'];
        }
        return $status === 'success' ? 'Transaction completed successfully' : 'Transaction failed or pending';
    }

    public function show($id)
    {
        $log = PaymentLog::with('payment')->findOrFail($id);
        return view('manage.payments.logs.show', compact('log'));
    }
}