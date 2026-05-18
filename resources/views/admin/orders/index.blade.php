@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')

<style>
/* ── Filter chips ── */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
}
.filter-chip {
    padding: .35rem .8rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.filter-chip:hover { border-color: #94a3b8; background: #f8fafc; }

/* ── Desktop table ── */
.orders-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.orders-table { width: 100%; min-width: 720px; border-collapse: collapse; }
.orders-table thead th {
    padding: .85rem 1rem;
    text-align: left;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #64748b;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
}
.orders-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
.orders-table tbody tr:hover { background: #fafbff; }
.orders-table tbody td { padding: .9rem 1rem; vertical-align: middle; }

/* ── Mobile cards ── */
.order-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #f1f5f9;
    padding: 1rem 1.1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    transition: box-shadow .15s;
}
.order-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }

/* ── Shared badge ── */
.badge {
    display: inline-flex; align-items: center;
    padding: .2rem .65rem;
    border-radius: 999px;
    font-size: .7rem; font-weight: 700;
    white-space: nowrap;
}

/* ── Action buttons ── */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    padding: .3rem .7rem;
    border-radius: 7px;
    font-size: .75rem; font-weight: 700;
    transition: all .12s;
    text-decoration: none;
    border: none; cursor: pointer;
}
.act-view   { background:#fffbeb; color:#d97706; }
.act-view:hover   { background:#fef3c7; }
.act-edit   { background:#eff6ff; color:#2563eb; }
.act-edit:hover   { background:#dbeafe; }
.act-delete { background:#fef2f2; color:#dc2626; }
.act-delete:hover { background:#fee2e2; }

/* ── Show/hide layers ── */
@media (max-width: 767px) { .desktop-only { display: none !important; } }
@media (min-width: 768px) { .mobile-only  { display: none !important; } }

/* ── Order number pill ── */
.order-num {
    font-family: ui-monospace, monospace;
    font-size: .72rem; font-weight: 700;
    background: #f1f5f9; color: #334155;
    padding: .15rem .55rem; border-radius: 6px;
}

/* ── Pagination wrapper ── */
.pagination-wrap { padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9; background: #f8fafc; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 4rem 1rem; color: #94a3b8; }
.empty-state svg { width: 48px; height: 48px; margin: 0 auto 1rem; opacity: .4; }
</style>

<div x-data="{ filterStatus: 'all' }">

    {{-- ── Header & Filters ── --}}
    <div class="bg-white rounded-2xl shadow-md p-5 mb-5" style="border:1px solid #f1f5f9;">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-serif font-bold text-slate-800 leading-tight">All Orders</h2>
                <p class="text-slate-400 text-xs mt-0.5">Manage and track customer orders</p>
            </div>
            {{-- Order count badge --}}
            <span class="self-start sm:self-auto text-xs font-bold bg-slate-100 text-slate-600 px-3 py-1.5 rounded-full">
                {{ $orders->total() }} total
            </span>
        </div>

        {{-- Filter chips --}}
        <div class="filter-bar">
            @foreach ([
                'all'       => ['label' => 'All',       'on' => 'bg-slate-800 text-white border-slate-800'],
                'pending'   => ['label' => '⏳ Pending',   'on' => 'bg-yellow-500 text-white border-yellow-500'],
                'confirmed' => ['label' => '✓ Confirmed', 'on' => 'bg-blue-500 text-white border-blue-500'],
                'preparing' => ['label' => '👨‍🍳 Preparing', 'on' => 'bg-purple-500 text-white border-purple-500'],
                'ready'     => ['label' => '✓ Ready',     'on' => 'bg-green-500 text-white border-green-500'],
                'delivered' => ['label' => '🚚 Delivered', 'on' => 'bg-teal-500 text-white border-teal-500'],
                'cancelled' => ['label' => '✗ Cancelled', 'on' => 'bg-red-500 text-white border-red-500'],
            ] as $status => $cfg)
                <button
                    @click="filterStatus = '{{ $status }}'"
                    :class="filterStatus === '{{ $status }}' ? '{{ $cfg['on'] }}' : ''"
                    class="filter-chip">
                    {{ $cfg['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ════════════════════════════════
         DESKTOP — table view (md+)
         ════════════════════════════════ --}}
    <div class="desktop-only bg-white rounded-2xl shadow-md overflow-hidden" style="border:1px solid #f1f5f9;">
        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $badges = [
                                'pending'   => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'preparing' => 'bg-purple-100 text-purple-800',
                                'ready'     => 'bg-green-100 text-green-800',
                                'delivered' => 'bg-teal-100 text-teal-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <tr x-show="filterStatus === 'all' || filterStatus === '{{ $order->status }}'">

                            <td><span class="order-num">{{ $order->order_number }}</span></td>

                            <td>
                                <p class="font-bold text-slate-800 text-sm leading-tight">{{ $order->customer_name }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $order->customer_phone }}</p>
                                <p class="text-xs text-slate-400">{{ $order->customer_email }}</p>
                            </td>

                            <td>
                                <span class="text-sm font-semibold text-slate-700">{{ $order->items->count() }} items</span>
                            </td>

                            <td>
                                <span class="font-bold text-amber-600">{{ site_setting('currency_symbol', '$') }}{{ number_format($order->total, 2) }}</span>
                            </td>

                            <td>
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1">{{ ucfirst($order->payment_method) }}</p>
                            </td>

                            <td>
                                <span class="badge {{ $badges[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <p class="text-xs font-semibold text-slate-700">{{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $order->created_at->format('h:i A') }}</p>
                            </td>

                            <td>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">View</a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="act-btn act-edit">Edit</a>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Delete this order? This cannot be undone.')"
                                            class="act-btn act-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="font-semibold text-slate-400">No orders found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">{{ $orders->links() }}</div>
    </div>

    {{-- ════════════════════════════════
         MOBILE — card view (< md)
         ════════════════════════════════ --}}
    <div class="mobile-only space-y-3">
        @forelse($orders as $order)
            @php
                $badges = [
                    'pending'   => 'bg-yellow-100 text-yellow-700',
                    'confirmed' => 'bg-blue-100 text-blue-700',
                    'preparing' => 'bg-purple-100 text-purple-700',
                    'ready'     => 'bg-green-100 text-green-700',
                    'delivered' => 'bg-teal-100 text-teal-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
                $statusLabel = ucfirst($order->status);
            @endphp

            <div class="order-card"
                 x-show="filterStatus === 'all' || filterStatus === '{{ $order->status }}'">

                {{-- Top row: order# + status --}}
                <div class="flex items-center justify-between mb-2.5">
                    <span class="order-num">{{ $order->order_number }}</span>
                    <span class="badge {{ $badges[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                {{-- Customer info --}}
                <div class="mb-2.5 pb-2.5" style="border-bottom:1px dashed #e2e8f0;">
                    <p class="font-bold text-slate-800 text-sm">{{ $order->customer_name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $order->customer_phone }}</p>
                    <p class="text-xs text-slate-400">{{ $order->customer_email }}</p>
                </div>

                {{-- Meta row --}}
                <div class="flex flex-wrap gap-x-4 gap-y-1 mb-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium">Items</span>
                        <span class="ml-1 font-bold text-slate-700">{{ $order->items->count() }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium">Total</span>
                        <span class="ml-1 font-bold text-amber-600">{{ site_setting('currency_symbol', '$') }}{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium">Payment</span>
                        <span class="ml-1 font-bold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        <span class="text-slate-400 ml-0.5">({{ ucfirst($order->payment_method) }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium">Date</span>
                        <span class="ml-1 font-semibold text-slate-600">{{ $order->created_at->format('M d') }}, {{ $order->created_at->format('h:i A') }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view flex-1" style="justify-content:center;">
                        View
                    </a>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="act-btn act-edit flex-1" style="justify-content:center;">
                        Edit
                    </a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Delete this order? This cannot be undone.')"
                            class="act-btn act-delete w-full">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <div class="empty-state bg-white rounded-2xl" style="border:1px solid #f1f5f9;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="font-semibold text-slate-400">No orders found</p>
            </div>
        @endforelse

        {{-- Mobile pagination --}}
        @if($orders->hasPages())
            <div class="bg-white rounded-2xl p-4" style="border:1px solid #f1f5f9;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
