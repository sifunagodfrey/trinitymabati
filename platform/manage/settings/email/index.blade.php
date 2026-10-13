@extends('manage.layouts.app')

@section('title', 'Email Settings')
@section('meta-description', 'Configure SMTP settings, sender email, and test email delivery for the Trinity Mabati Factory platform.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.email.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Email Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Email Configuration</h1>
                <p class="text-sm text-muted">Configure SMTP settings and sender details for outgoing platform emails.</p>
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

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ---------------
    -- Email Settings Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <form method="POST" action="{{ route('manage.settings.email.update') }}">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Mail Driver --}}
                <div>
                    <label for="mail_driver" class="block text-sm font-medium text-black mb-1">Mail Driver</label>
                    <select id="mail_driver" name="mail_driver"
                            class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                        <option value="smtp" {{ old('mail_driver', $emailSettings?->mail_driver) === 'smtp' ? 'selected' : '' }}>SMTP</option>
                        <option value="sendmail" {{ old('mail_driver', $emailSettings?->mail_driver) === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        <option value="mailgun" {{ old('mail_driver', $emailSettings?->mail_driver) === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                    </select>
                    @error('mail_driver') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Encryption --}}
                <div>
                    <label for="smtp_encrypt" class="block text-sm font-medium text-black mb-1">Encryption</label>
                    <select id="smtp_encrypt" name="smtp_encrypt"
                            class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                        <option value="tls" {{ old('smtp_encrypt', $emailSettings?->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('smtp_encrypt', $emailSettings?->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="none" {{ old('smtp_encrypt', $emailSettings?->mail_encryption) === 'none' ? 'selected' : '' }}>None</option>
                    </select>
                    @error('smtp_encrypt') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Sender Email --}}
                <div>
                    <label for="mail_from" class="block text-sm font-medium text-black mb-1">Sender Email</label>
                    <input type="email" id="mail_from" name="mail_from"
                           value="{{ old('mail_from', $emailSettings?->mail_from_address) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('mail_from') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Sender Name --}}
                <div>
                    <label for="mail_name" class="block text-sm font-medium text-black mb-1">Sender Name</label>
                    <input type="text" id="mail_name" name="mail_name"
                           value="{{ old('mail_name', $emailSettings?->mail_from_name) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('mail_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- SMTP Host --}}
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-black mb-1">SMTP Host</label>
                    <input type="text" id="smtp_host" name="smtp_host"
                           value="{{ old('smtp_host', $emailSettings?->mail_host) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('smtp_host') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- SMTP Port --}}
                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-black mb-1">SMTP Port</label>
                    <input type="number" id="smtp_port" name="smtp_port"
                           value="{{ old('smtp_port', $emailSettings?->mail_port) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('smtp_port') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- SMTP Username --}}
                <div>
                    <label for="smtp_user" class="block text-sm font-medium text-black mb-1">SMTP Username</label>
                    <input type="text" id="smtp_user" name="smtp_user"
                           value="{{ old('smtp_user', $emailSettings?->mail_username) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('smtp_user') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- SMTP Password --}}
                <div>
                    <label for="smtp_pass" class="block text-sm font-medium text-black mb-1">SMTP Password</label>
                    <input type="password" id="smtp_pass" name="smtp_pass"
                           placeholder="Leave blank to keep current password"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none">
                    @error('smtp_pass') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('manage.settings.email.index') }}"
                   class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary-dark">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection
