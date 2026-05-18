@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
/* ── Responsive dashboard overrides ── */

/* Welcome bar */
.dash-welcome {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
@media (min-width: 640px) {
    .dash-welcome {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
}

.dash-welcome-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
@media (max-width: 639px) {
    .dash-welcome-actions { width: 100%; }
    .dash-welcome-actions a,
    .dash-welcome-actions button { flex: 1; justify-content: center; font-size: .85rem; padding: .5rem .75rem; }
}

/* Stats grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.875rem;
    margin-bottom: 1.75rem;
}
@media (min-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.1rem 1.1rem 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 14px rgba(0,0,0,.06);
    border-left: 4px solid transparent;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    transition: box-shadow .2s, transform .2s;
}
.stat-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.1); transform: translateY(-2px); }

.stat-icon {
    flex-shrink: 0;
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
@media (max-width: 639px) {
    .stat-icon { width: 36px; height: 36px; }
    .stat-icon svg { width: 20px; height: 20px; }
    .stat-num { font-size: 1.75rem !important; }
    .stat-card { padding: .9rem .85rem .85rem; }
}

.stat-num { font-size: 2.25rem; font-weight: 800; color: #1e293b; line-height: 1; }
.stat-label { font-size: .72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .04em; margin-bottom: .25rem; }
.stat-sub { font-size: .72rem; color: #94a3b8; margin-top: .35rem; }

/* Main grid */
.main-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}
@media (min-width: 1024px) {
    .main-grid { grid-template-columns: 1fr 1fr 1fr; }
}

.orders-panel { grid-column: span 1; }
@media (min-width: 1024px) { .orders-panel { grid-column: span 2; } }

/* Table scroll */
.table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.table-wrap table { min-width: 520px; }

/* Hide less-important columns on small screens */
@media (max-width: 767px) {
    .col-items, .col-time { display: none; }
}

/* Sidebar panels */
.sidebar-panels { display: flex; flex-direction: column; gap: 1.25rem; }

/* Popular dish card */
.dish-row {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .65rem .75rem;
    background: #f8fafc;
    border-radius: 10px;
    transition: background .15s;
}
.dish-row:hover { background: #f1f5f9; }
.dish-img { width: 46px; height: 46px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
@media (max-width: 639px) {
    .dish-img { width: 38px; height: 38px; }
}

/* Quick action rows */
.qa-link {
    display: flex; align-items: center; gap: .75rem;
    padding: .7rem .85rem;
    background: #f8fafc;
    border-radius: 10px;
    transition: background .15s, transform .15s;
    text-decoration: none;
}
.qa-link:hover { background: #f1f5f9; transform: translateX(3px); }
.qa-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

/* Status badge */
.status-badge { display: inline-flex; align-items: center; padding: .2rem .65rem; border-radius: 999px; font-size: .7rem; font-weight: 700; white-space: nowrap; }

/* Mobile stat action */
.view-all-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #f59e0b; color: #1a1a1a;
    font-weight: 700; font-size: .85rem;
    padding: .5rem 1.1rem; border-radius: 9px;
    border: none; cursor: pointer; transition: background .15s;
    text-decoration: none;
}
.view-all-btn:hover { background: #d97706; }

.refresh-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #475569;
    font-weight: 600; font-size: .85rem;
    padding: .5rem 1rem; border-radius: 9px;
    border: 1.5px solid #e2e8f0; cursor: pointer; transition: background .15s;
}
.refresh-btn:hover { background: #f8fafc; }
</style>

<!-- Welcome Section -->
<div class="dash-welcome mb-6">
    <div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-slate-800 leading-tight">Dashboard Overview</h1>
        <p class="text-slate-500 text-sm mt-1">Welcome back, <span class="font-semibold text-slate-700">{{ auth('admin')->user()->name }}</span>! Here's your restaurant performance.</p>
    </div>
    <div class="dash-welcome-actions">
        <button onclick="window.location.reload()" class="refresh-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Refresh
        </button>
        <a href="{{ route('admin.orders.index') }}" class="view-all-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            View All Orders
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">

    <!-- Total Orders -->
    <div class="stat-card" style="border-left-color:#3b82f6;">
        <div>
            <p class="stat-label">Total Orders</p>
            <h3 class="stat-num">{{ $stats['total_orders'] }}</h3>
            <p class="stat-sub">All time</p>
        </div>
        <div class="stat-icon" style="background:#eff6ff;">
            <svg class="w-6 h-6" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="stat-card" style="border-left-color:#f59e0b;">
        <div>
            <p class="stat-label">Pending</p>
            <h3 class="stat-num">{{ $stats['pending_orders'] }}</h3>
            <p class="stat-sub" style="color:{{ $stats['pending_orders'] > 0 ? '#d97706' : '#94a3b8' }}; font-weight:{{ $stats['pending_orders'] > 0 ? '700' : '400' }};">
                {{ $stats['pending_orders'] > 0 ? 'Action needed' : 'All clear' }}
            </p>
        </div>
        <div class="stat-icon" style="background:#fffbeb;">
            <svg class="w-6 h-6" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <!-- Today's Orders -->
    <div class="stat-card" style="border-left-color:#22c55e;">
        <div>
            <p class="stat-label">Today's Orders</p>
            <h3 class="stat-num">{{ $stats['today_orders'] }}</h3>
            <p class="stat-sub">{{ now()->format('M d, Y') }}</p>
        </div>
        <div class="stat-icon" style="background:#f0fdf4;">
            <svg class="w-6 h-6" style="color:#22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
    </div>

    <!-- Today's Revenue -->
    <div class="stat-card" style="border-left-color:#a855f7;">
        <div>
            <p class="stat-label">Today's Revenue</p>
            <h3 class="stat-num" style="font-size:1.6rem;">${{ number_format($stats['today_revenue'], 2) }}</h3>
            <p class="stat-sub">Total: ${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="stat-icon" style="background:#faf5ff;">
            <svg class="w-6 h-6" style="color:#a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

</div>

<!-- Main Content Grid -->
<div class="main-grid">

    <!-- Recent Orders Panel -->
    <div class="orders-panel">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="border:1px solid #f1f5f9;">
            <div class="flex items-center justify-between px-5 py-4" style="background:linear-gradient(135deg,#1e293b,#0f172a);">
                <div>
                    <h2 class="text-lg sm:text-xl font-serif font-bold text-white">Recent Orders</h2>
                    <p class="text-slate-400 text-xs mt-0.5">Latest customer orders</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="view-all-btn" style="font-size:.78rem; padding:.4rem .85rem;">
                    View All
                </a>
            </div>

            <div class="table-wrap">
                <table class="w-full" style="min-width:520px;">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide">Order #</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide">Customer</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide col-items">Items</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide">Total</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wide col-time">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr style="border-bottom:1px solid #f1f5f9;" class="hover:bg-slate-50 transition-colors">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md">{{ $order->order_number }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $order->customer_phone }}</p>
                                </td>
                                <td class="py-3.5 px-4 col-items">
                                    <span class="text-sm text-slate-600 font-medium">{{ $order->items->count() }} items</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-amber-600 text-sm">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="status-badge {{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="py-3.5 px-4 col-time">
                                    <p class="text-xs font-medium text-slate-700">{{ $order->created_at->format('M d') }}</p>
                                    <p class="text-xs text-slate-400">{{ $order->created_at->format('h:i A') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-14">
                                    <div class="text-slate-300">
                                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-sm font-semibold text-slate-400">No orders yet</p>
                                        <p class="text-xs text-slate-300 mt-1">Orders will appear here when customers place them</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-panels">

        <!-- Popular Dishes -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="border:1px solid #f1f5f9;">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <h2 class="text-base sm:text-lg font-serif font-bold text-slate-900">Popular Dishes</h2>
                <p class="text-amber-900 text-xs mt-0.5 opacity-75">Last 30 days</p>
            </div>

            <div class="p-4 space-y-2.5">
                @forelse($popularDishes as $index => $dish)
                    <div class="dish-row">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm text-white" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                            {{ $index + 1 }}
                        </div>
                        <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}" class="dish-img">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-slate-800 text-sm truncate leading-tight">{{ $dish->name }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">${{ number_format($dish->price, 2) }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $dish->order_items_count }}</span>
                            <p class="text-xs text-slate-400 mt-0.5">orders</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-400">No data yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-md p-5" style="border:1px solid #f1f5f9;">
            <h3 class="text-base font-serif font-bold text-slate-800 mb-3">Quick Actions</h3>
            <div class="space-y-2">

                <a href="{{ route('admin.orders.index') }}" class="qa-link">
                    <div class="qa-icon" style="background:#eff6ff;">
                        <svg class="w-5 h-5" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Manage Orders</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('menu') }}" target="_blank" class="qa-link">
                    <div class="qa-icon" style="background:#f0fdf4;">
                        <svg class="w-5 h-5" style="color:#22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">View Menu</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="qa-link">
                    <div class="qa-icon" style="background:#faf5ff;">
                        <svg class="w-5 h-5" style="color:#a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Visit Website</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

            </div>
        </div>

    </div>
</div>

@endsection
