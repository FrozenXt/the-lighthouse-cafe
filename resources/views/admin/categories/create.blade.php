@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-serif font-bold text-slate-800">Create Category</h1>
            <p class="text-slate-600 mt-2">Add a new menu category</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition @error('name') border-red-500 @enderror"
                    placeholder="e.g., Appetizers, Desserts, Pasta, Seafood, Drinks" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-900 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition @error('description') border-red-500 @enderror"
                    placeholder="Brief description of this category">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Display Order Field -->
            <div>
                <label for="display_order" class="block text-sm font-semibold text-slate-900 mb-2">Display Order</label>
                <input type="number" id="display_order" name="display_order" value="{{ old('display_order', 0) }}"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition @error('display_order') border-red-500 @enderror"
                    placeholder="0" min="0">
                <p class="text-slate-500 text-sm mt-1">Lower numbers appear first on the menu</p>
                @error('display_order')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded text-teal-600">
                    <span class="text-sm font-semibold text-slate-900">Category is active (visible on menu)</span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-900 rounded-lg font-semibold transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition">
                    Create Category
                </button>
            </div>
        </form>
    </div>
@endsection
