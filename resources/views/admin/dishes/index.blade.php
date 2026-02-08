@extends('admin.layouts.app')

@section('title', 'Menu Management')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-serif font-bold text-slate-800 mb-2">Menu Management</h2>
                <p class="text-slate-600">Manage all dishes and menu items</p>
            </div>
            <a href="{{ route('admin.dishes.create') }}"
                class="bg-amber-500 hover:bg-amber-600 text-slate-900 px-6 py-3 rounded-lg font-bold transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Dish
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Total Dishes</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dishes->total() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Available</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dishes->where('is_available', true)->count() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Featured Today</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dishes->where('featured_type', 'day')->count() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Featured Week</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dishes->where('featured_type', 'week')->count() }}</h3>
        </div>
    </div>

    <!-- Dishes Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b-2 border-slate-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Image</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Name</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Category</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Price</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Rating</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Featured</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Status</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dishes as $dish)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                @if ($dish->image)
                                    <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}"
                                        class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-slate-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $dish->name }}</p>
                                    <p class="text-sm text-slate-600 line-clamp-1">{{ $dish->description }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ $dish->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-lg text-amber-600">${{ number_format($dish->price, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="font-semibold">{{ $dish->rating }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if ($dish->featured_type === 'day')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Day</span>
                                @elseif($dish->featured_type === 'week')
                                    <span
                                        class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold">Week</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold">None</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.dishes.toggle-availability', $dish) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-bold transition {{ $dish->is_available ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        {{ $dish->is_available ? 'Available' : 'Unavailable' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.dishes.edit', $dish) }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.dishes.destroy', $dish) }}" method="POST"
                                        onsubmit="return confirm('Delete this dish?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-500">
                                <p class="text-lg font-semibold">No dishes found</p>
                                <a href="{{ route('admin.dishes.create') }}"
                                    class="text-amber-600 hover:text-amber-700 mt-2 inline-block">Add your first dish</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-200 bg-slate-50">
            {{ $dishes->links() }}
        </div>
    </div>
@endsection
