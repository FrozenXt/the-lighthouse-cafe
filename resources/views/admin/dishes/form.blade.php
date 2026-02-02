<!-- resources/views/admin/dishes/form.blade.php -->
<div class="space-y-6 mb-8">
    <div>
        <label class="block text-slate-700 font-bold mb-2">Dish Name *</label>
        <input type="text" name="name" value="{{ old('name', $dish->name ?? '') }}" required
            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-slate-700 font-bold mb-2">Description *</label>
        <textarea name="description" rows="4" required
            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">{{ old('description', $dish->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-slate-700 font-bold mb-2">Category *</label>
            <select name="category" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}"
                        {{ old('category', $dish->category ?? '') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-2">Price ($) *</label>
            <input type="number" name="price" step="0.01" min="0"
                value="{{ old('price', $dish->price ?? '') }}" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-slate-700 font-bold mb-2">Rating (0-5) *</label>
            <input type="number" name="rating" step="0.1" min="0" max="5"
                value="{{ old('rating', $dish->rating ?? '4.5') }}" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
            @error('rating')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-2">Featured Type *</label>
            <select name="featured_type" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                <option value="none"
                    {{ old('featured_type', $dish->featured_type ?? 'none') == 'none' ? 'selected' : '' }}>None
                </option>
                <option value="day"
                    {{ old('featured_type', $dish->featured_type ?? '') == 'day' ? 'selected' : '' }}>Featured Today
                </option>
                <option value="week"
                    {{ old('featured_type', $dish->featured_type ?? '') == 'week' ? 'selected' : '' }}>Featured This
                    Week</option>
            </select>
            @error('featured_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-slate-700 font-bold mb-2">Image URL *</label>
        <input type="url" name="image" value="{{ old('image', $dish->image ?? '') }}" required
            placeholder="https://images.unsplash.com/photo-..."
            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
        <p class="text-sm text-slate-500 mt-1">Enter the full URL of the dish image</p>
        @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    @if (isset($dish) && $dish->image)
        <div>
            <label class="block text-slate-700 font-bold mb-2">Current Image Preview</label>
            <img src="{{ $dish->image }}" alt="{{ $dish->name }}"
                class="w-48 h-48 object-cover rounded-lg border-2 border-slate-300">
        </div>
    @endif
</div>
