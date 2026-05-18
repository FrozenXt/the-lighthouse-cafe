@extends('admin.layouts.app')

@section('title', 'Menu Management')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="menu-header mb-4">

        <div>
            <h2 class="title">Menu Management</h2>
            <p class="subtitle">Manage dishes, pricing and availability</p>
        </div>

        <a href="{{ route('admin.dishes.create') }}" class="add-btn">
            + Add Dish
        </a>

    </div>

    {{-- STATS --}}
    <div class="stats-row mb-3">

        <div class="stat">
            <span>Total</span>
            <h3>{{ $dishes->total() }}</h3>
        </div>

        <div class="stat">
            <span>Available</span>
            <h3>{{ $dishes->where('is_available', true)->count() }}</h3>
        </div>

        <div class="stat">
            <span>Today Specials</span>
            <h3>{{ $dishes->where('featured_type', 'day')->count() }}</h3>
        </div>

        <div class="stat">
            <span>Week Specials</span>
            <h3>{{ $dishes->where('featured_type', 'week')->count() }}</h3>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="menu-card">

        <table class="menu-table">

            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dishes as $dish)

                    <tr>

                        {{-- DISH --}}
                        <td>
                            <div class="dish">

                                <img src="{{ $dish->image_url ?? 'https://via.placeholder.com/60' }}"
                                     class="dish-img">

                                <div>
                                    <div class="dish-name">{{ $dish->name }}</div>
                                    <div class="dish-desc">
                                        {{ \Illuminate\Support\Str::limit($dish->description, 50) }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        {{-- CATEGORY --}}
                        <td>
                            <span class="badge">
                                {{ $dish->category ?? 'Uncategorized' }}
                            </span>
                        </td>

                        {{-- PRICE --}}
                        <td class="price">
                            ${{ number_format($dish->price, 2) }}
                        </td>

                        {{-- RATING --}}
                        <td>
                            ⭐ {{ $dish->rating }}
                        </td>

                        {{-- FEATURED --}}
                        <td>
                            @if($dish->featured_type == 'day')
                                <span class="tag green">Today</span>
                            @elseif($dish->featured_type == 'week')
                                <span class="tag purple">Week</span>
                            @else
                                <span class="tag gray">None</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <form action="{{ route('admin.dishes.toggle-availability', $dish) }}" method="POST">
                                @csrf
                                <button class="status-btn {{ $dish->is_available ? 'on' : 'off' }}">
                                    {{ $dish->is_available ? 'Available' : 'Hidden' }}
                                </button>
                            </form>
                        </td>

                        {{-- ACTION --}}
                        <td class="actions">

                            <a href="{{ route('admin.dishes.edit', $dish) }}">Edit</a>

                            <form action="{{ route('admin.dishes.destroy', $dish) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete dish?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit">Delete</button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty">
                            No dishes found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $dishes->links() }}
    </div>

</div>

{{-- STYLE --}}
<style>

body {
    background: #f6f7fb;
}

.menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title {
    font-size: 22px;
    font-weight: 700;
}

.subtitle {
    font-size: 13px;
    color: #777;
}

.add-btn {
    background: #111;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.stat {
    background: #fff;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #eee;
}

.stat span {
    font-size: 12px;
    color: #888;
}

.stat h3 {
    margin: 0;
    font-size: 18px;
}

.menu-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #eee;
    overflow: hidden;
}

.menu-table {
    width: 100%;
    border-collapse: collapse;
}

.menu-table th {
    background: #fafafa;
    font-size: 12px;
    text-align: left;
    padding: 12px;
    color: #666;
}

.menu-table td {
    padding: 12px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 13px;
}

.dish {
    display: flex;
    gap: 10px;
    align-items: center;
}

.dish-img {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    object-fit: cover;
}

.dish-name {
    font-weight: 600;
}

.dish-desc {
    font-size: 11px;
    color: #888;
}

.badge {
    background: #eef2ff;
    color: #4f46e5;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 11px;
}

.price {
    font-weight: 700;
    color: #f59e0b;
}

.tag {
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 11px;
}

.green { background:#dcfce7; color:#166534; }
.purple { background:#ede9fe; color:#5b21b6; }
.gray { background:#f3f4f6; color:#6b7280; }

.status-btn {
    border: none;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
}

.status-btn.on {
    background: #dcfce7;
    color: #166534;
}

.status-btn.off {
    background: #fee2e2;
    color: #991b1b;
}

.actions {
    display: flex;
    gap: 6px;
}

.actions a {
    background: #e0f2fe;
    color: #0369a1;
    padding: 4px 8px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
}

.actions button {
    background: #fee2e2;
    color: #b91c1c;
    border: none;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
}

.empty {
    text-align: center;
    padding: 30px;
    color: #888;
}

</style>

@endsection
