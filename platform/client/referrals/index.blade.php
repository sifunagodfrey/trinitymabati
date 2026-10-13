{{-- ---------------
-- Client Referrals Overview
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'My Referrals | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Refer and Earn</h2>
            <p class="text-sm text-gray-500 mt-0.5">Share your link with friends and earn rewards when they join and shop.</p>
        </div>
    </div>

    {{-- ---------------
    -- Flash Messages
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
        </div>
    @endif

    @unless ($programEnabled)
        <div class="mb-5 flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-info-circle text-amber-500"></i>
            The referral program is currently paused. Your link will work again once it resumes.
        </div>
    @endunless

    {{-- ---------------
    -- Referral Link Card
    -- --------------- --}}
    <div class="bg-white border border-gray-200 rounded-[12px] p-5 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-gray-900">Your Referral Link</h3>
            <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                {{ $code->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                {{ $code->is_active ? 'Active' : 'Paused' }}
            </span>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center"
             x-data="{ copied: false, copy() { navigator.clipboard.writeText('{{ $code->shareUrl() }}'); this.copied = true; setTimeout(() => this.copied = false, 2000); } }">
            <input type="text" readonly value="{{ $code->shareUrl() }}"
                class="flex-1 rounded-[8px] border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 font-mono outline-none" />
            <button type="button" @click="copy()"
                class="inline-flex items-center justify-center gap-2 rounded-[8px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90">
                <i class="fas" :class="copied ? 'fa-check' : 'fa-copy'"></i>
                <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
            <form method="POST" action="{{ route('client.referrals.generate') }}"
                  onsubmit="return confirm('Generate a new link? Your current link will stop working.')">
                @csrf
                <button type="submit" class="text-primary font-medium hover:underline">
                    <i class="fas fa-arrows-rotate text-xs mr-1"></i> Generate New Link
                </button>
            </form>
            <span class="text-gray-300">|</span>
            <form method="POST" action="{{ route('client.referrals.toggle') }}">
                @csrf
                <button type="submit" class="text-gray-600 font-medium hover:underline">
                    <i class="fas {{ $code->is_active ? 'fa-pause' : 'fa-play' }} text-xs mr-1"></i>
                    {{ $code->is_active ? 'Pause Link' : 'Activate Link' }}
                </button>
            </form>
        </div>
    </div>

    {{-- ---------------
    -- Stats
    -- --------------- --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-[12px] p-4">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Link Clicks</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($stats['clicks']) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-[12px] p-4">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Signups</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($stats['signups']) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-[12px] p-4">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Rewarded</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($stats['rewarded']) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-[12px] p-4">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Earned</p>
            <p class="text-xl font-bold text-gray-900 mt-1">KES {{ number_format($stats['earned'], 2) }}</p>
        </div>
    </div>

    {{-- ---------------
    -- Referral History
    -- --------------- --}}
    <div class="bg-white border border-gray-200 rounded-[12px] overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900">Referral History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Friend</th>
                        <th class="px-5 py-3">Joined</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Reward</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($events as $event)
                        @php
                            $statusColors = [
                                'pending'   => 'bg-amber-100 text-amber-800',
                                'qualified' => 'bg-blue-100 text-blue-800',
                                'rewarded'  => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-slate-100 text-slate-600',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3.5 text-gray-900 font-medium">
                                {{ $event->referred?->first_name ?? 'New customer' }}
                            </td>
                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $event->created_at?->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex rounded-[12px] px-2.5 py-0.5 text-xs font-semibold
                                    {{ $statusColors[$event->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right text-gray-900 font-medium">
                                @if ($event->status === 'rewarded')
                                    KES {{ number_format($event->reward_amount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-user-plus text-2xl text-gray-300"></i>
                                    No referrals yet. Share your link to start earning.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($events->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $events->links() }}</div>
        @endif
    </div>

@endsection
