@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-serif font-bold text-slate-800">{{ $category->name }}</h1>
                <p class="text-slate-600 mt-2">Viewing category details and associated dishes</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.edit', $category) }}"
            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            Edit Category
        </a>
    </div>

    <!-- Category Details Card -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Basic Info -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Category Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-600">Name</label>
                        <p class="text-slate-900 mt-1">{{ $category->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-600">Description</label>
                        <p class="text-slate-900 mt-1">{{ $category->description ?? 'No description' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-600">Display Order</label>
                        <p class="text-slate-900 mt-1">#{{ $category->display_order }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Category Stats</h3>
                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-600 font-semibold">Total Dishes</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $category->dishes->count() }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-sm text-slate-600 font-semibold">Status</p>
                        <div class="mt-2">
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full font-semibold {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                <span
                                    class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Associated Dishes -->
    <div>
        <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Dishes in this Category</h2>

        @if ($dishes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($dishes as $dish)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="relative overflow-hidden h-40">
                            <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $dish->name }}</h3>
                            <p class="text-slate-600 text-sm mb-4">{{ Str::limit($dish->description, 80) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-teal-600">${{ number_format($dish->price, 2) }}</span>
                                <a href="{{ route('admin.dishes.edit', $dish) }}"
                                    class="text-orange-600 hover:text-orange-700 font-semibold text-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $dishes->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m0 0h6M6 12a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <p class="text-slate-600 text-lg font-semibold mb-4">No dishes in this category yet</p>
                <a href="{{ route('admin.dishes.create') }}"
                    class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Add Dish
                </a>
            </div>
        @endif
    </div>
@endsection
