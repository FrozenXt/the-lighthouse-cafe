@extends('admin.layouts.app')

@section('title', 'Menu Categories')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-serif font-bold text-slate-800">Menu Categories</h1>
            <p class="text-slate-600 mt-2">Manage your menu categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <div class="flex-1">
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <div class="flex-1">
                <p class="text-red-800 font-semibold">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Categories Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if ($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Description</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Items</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Order</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-900">{{ $category->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-slate-600">{{ Str::limit($category->description, 50) ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-semibold text-slate-900">{{ $category->dishes->count() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">#{{ $category->display_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.categories.toggle-active', $category) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold transition {{ $category->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                            @if ($category->is_active)
                                                <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                                Active
                                            @else
                                                <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                                                Inactive
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.categories.show', $category) }}"
                                            class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition p-2 hover:bg-blue-50 rounded"
                                            title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="text-orange-600 hover:text-orange-700 font-semibold text-sm transition p-2 hover:bg-orange-50 rounded"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-700 font-semibold text-sm transition p-2 hover:bg-red-50 rounded"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $categories->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-slate-600 text-lg font-semibold mb-4">No categories found</p>
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Create First Category
                </a>
            </div>
        @endif
    </div>
@endsection
