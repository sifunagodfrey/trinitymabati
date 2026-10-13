{{-- -------------------
     Admin SMS Settings - Africa's Talking configuration, test send
     and recent delivery log
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'SMS Settings')
@section('meta-description', 'Configure SMS credentials, sender id and review recent SMS delivery for the Trinity Mabati Factory platform.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.sms.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">SMS Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">SMS Configuration</h1>
                <p class="text-sm text-muted">Configure the Africa's Talking account used for signup verification, order updates and stock alerts.</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ---------------
        -- Settings Form
        -- --------------- --}}
        <div class="xl:col-span-2 bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-black mb-4">Credentials</h2>

            <form method="POST" action="{{ route('manage.settings.sms.update') }}">
                @csrf

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-black mb-1">Username</label>
                        <input type="text" id="username" name="username"
                               value="{{ old('username', $settings->username) }}"
                               placeholder="sandbox"
                               class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary"
                               required>
                        <p class="mt-1 text-xs text-muted">Use "sandbox" for the test environment, or your live app username.</p>
                    </div>

                    {{-- Sender Id --}}
                    <div>
                        <label for="sender_id" class="block text-sm font-medium text-black mb-1">Sender Id / Shortcode</label>
                        <input type="text" id="sender_id" name="sender_id"
                               value="{{ old('sender_id', $settings->sender_id) }}"
                               placeholder="HAROMI"
                               class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-muted">Optional. Approved alphanumeric sender id or shortcode.</p>
                    </div>

                    {{-- Api Key --}}
                    <div class="sm:col-span-2">
                        <label for="api_key" class="block text-sm font-medium text-black mb-1">API Key</label>
                        <input type="password" id="api_key" name="api_key"
                               value="{{ old('api_key', $settings->api_key) }}"
                               class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary"
                               required>
                    </div>

                    {{-- Environment --}}
                    <div>
                        <label for="environment" class="block text-sm font-medium text-black mb-1">Environment</label>
                        <select id="environment" name="environment"
                                class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                            <option value="sandbox" @selected(old('environment', $settings->environment) === 'sandbox')>Sandbox (testing)</option>
                            <option value="production" @selected(old('environment', $settings->environment) === 'production')>Production (live)</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-black mb-1">SMS Sending</label>
                        <select id="is_active" name="is_active"
                                class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                            <option value="1" @selected(old('is_active', $settings->is_active ? '1' : '0') == '1')>Enabled</option>
                            <option value="0" @selected(old('is_active', $settings->is_active ? '1' : '0') == '0')>Disabled</option>
                        </select>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="rounded-[8px] bg-primary px-6 py-2.5 text-sm font-semibold text-white hover:opacity-90">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        {{-- ---------------
        -- Test Send
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm h-fit">
            <h2 class="text-lg font-semibold text-black mb-2">Send a Test SMS</h2>
            <p class="text-sm text-muted mb-4">Saves are applied first. Save your settings, then send a test message to confirm delivery.</p>

            <form method="POST" action="{{ route('manage.settings.sms.test') }}">
                @csrf

                <label for="test_phone" class="block text-sm font-medium text-black mb-1">Phone Number</label>
                <input type="text" id="test_phone" name="test_phone"
                       value="{{ old('test_phone') }}"
                       placeholder="0712345678"
                       class="w-full rounded-[8px] border border-border bg-background px-4 py-2.5 text-sm focus:border-primary focus:ring-primary"
                       required>
                <p class="mt-1 text-xs text-muted">Kenyan numbers are normalized to +254 automatically.</p>

                <button type="submit"
                        class="mt-4 w-full rounded-[8px] border border-primary px-6 py-2.5 text-sm font-semibold text-primary hover:bg-primary-light">
                    Send Test Message
                </button>
            </form>
        </div>
    </div>

    {{-- ---------------
    -- Recent Log
    -- --------------- --}}
    <div class="mt-6 bg-background border border-border rounded-[12px] shadow-sm overflow-hidden">
        <div class="px-6 pt-6 pb-3">
            <h2 class="text-lg font-semibold text-black">Recent Messages</h2>
            <p class="text-sm text-muted">The last {{ $logs->count() }} SMS attempts, newest first.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[600px] text-sm">
                <thead>
                    <tr class="border-y border-border bg-primary-light/40 text-left text-xs uppercase tracking-wide text-muted">
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-muted">{{ $log->created_at?->format('d M Y H:i') }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $log->phone }}</td>
                            <td class="px-6 py-3 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $log->type) }}</td>
                            <td class="px-6 py-3 max-w-md truncate" title="{{ $log->message }}">{{ $log->message }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @if ($log->status === 'sent')
                                    <span class="inline-flex rounded-[12px] bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Sent</span>
                                @elseif ($log->status === 'queued')
                                    <span class="inline-flex rounded-[12px] bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Queued</span>
                                @elseif ($log->status === 'skipped')
                                    <span class="inline-flex rounded-[12px] bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">Skipped</span>
                                @else
                                    <span class="inline-flex rounded-[12px] bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Failed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-muted">No SMS messages have been sent yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
