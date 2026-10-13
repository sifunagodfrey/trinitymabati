@extends('manage.layouts.app')

@section('title', 'Optimization Settings')
@section('meta-description',
    'Manage cache, database cleanup, and performance optimization options for the Trinity Mabati Factory admin
    panel.')

@section('content')
    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.optimization.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Optimization</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">System Optimization Tools</h1>
                <p class="text-sm text-muted">Use the tools below to optimize system performance. These actions are safe and
                    help resolve cache-related or speed issues.</p>
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

    @if (session('info'))
        <div class="mb-6 rounded-[12px] border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
            {{ session('info') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    {{-- ---------------
    -- Optimization Actions Panel
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-6">Optimization Actions</h2>

        <div class="space-y-4">

            {{-- Clear Cache --}}
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-[12px] border border-border bg-white p-4">
                <div>
                    <p class="text-sm font-semibold text-black">Clear Application Cache</p>
                    <p class="text-xs text-muted">Clears application cache, config cache, compiled views, route cache, and
                        event cache. Run this after deployments or config changes.</p>
                </div>
                <form method="POST" action="{{ route('manage.settings.optimization.clear-cache') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="rounded-[8px] border border-amber-400 bg-amber-50 px-4 py-2 text-sm font-medium text-amber-800 hover:bg-amber-100 transition">
                        <i class="fa-solid fa-broom mr-1"></i>
                        Clear Cache
                    </button>
                </form>
            </div>

            {{-- Optimize Assets --}}
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-[12px] border border-border bg-white p-4">
                <div>
                    <p class="text-sm font-semibold text-black">Optimize Assets</p>
                    <p class="text-xs text-muted">Compress and minify public CSS/JS files for faster page load. Requires a
                        terminal build step.</p>
                </div>
                <form method="POST" action="{{ route('manage.settings.optimization.optimize-assets') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="rounded-[8px] border border-blue-300 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-800 hover:bg-blue-100 transition">
                        <i class="fa-solid fa-box-archive mr-1"></i>
                        Minify CSS/JS
                    </button>
                </form>
            </div>

            {{-- Clean Database --}}
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-[12px] border border-border bg-white p-4">
                <div>
                    <p class="text-sm font-semibold text-black">Clean Database</p>
                    <p class="text-xs text-muted">Removes expired POS sessions, stale framework sessions (24h+), and pending
                        M-Pesa records older than 24 hours.</p>
                </div>
                <form method="POST" action="{{ route('manage.settings.optimization.clean-database') }}" class="shrink-0"
                    onsubmit="return confirm('This will delete expired sessions and stale M-Pesa records older than 24h. Continue?');">
                    @csrf
                    <button type="submit"
                        class="rounded-[8px] border border-rose-300 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-800 hover:bg-rose-100 transition">
                        <i class="fa-solid fa-trash-can mr-1"></i>
                        Remove Temp Data
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- ---------------
    -- System Information Panel
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <h2 class="text-base font-semibold text-black mb-4">System Information</h2>

        <div class="overflow-hidden rounded-[12px] border border-border bg-white divide-y divide-border">
            <div class="flex items-center justify-between px-5 py-3">
                <span class="text-sm text-muted">PHP Version</span>
                <span class="text-sm font-semibold text-black">{{ $systemInfo['php_version'] }}</span>
            </div>
            <div class="flex items-center justify-between px-5 py-3">
                <span class="text-sm text-muted">Server Software</span>
                <span class="text-sm font-semibold text-black">{{ $systemInfo['server_software'] }}</span>
            </div>
            <div class="flex items-center justify-between px-5 py-3">
                <span class="text-sm text-muted">Memory Limit</span>
                <span class="text-sm font-semibold text-black">{{ $systemInfo['memory_limit'] }}</span>
            </div>
            <div class="flex items-center justify-between px-5 py-3">
                <span class="text-sm text-muted">Max Upload Size</span>
                <span class="text-sm font-semibold text-black">{{ $systemInfo['max_upload_size'] }}</span>
            </div>
        </div>
    </div>
@endsection
