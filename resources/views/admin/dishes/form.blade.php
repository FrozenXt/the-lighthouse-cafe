<div class="space-y-6 mb-8" x-data="imageUpload()">
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
            <select name="category_id" required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $dish->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
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

    <!-- IMAGE UPLOAD SECTION -->
    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 bg-slate-50">
        <label class="block text-slate-700 font-bold mb-4">Dish Image *</label>

        <!-- Current Image Preview -->
        @if (isset($dish) && $dish->image)
            <div class="mb-4">
                <p class="text-sm text-slate-600 mb-2">Current Image:</p>
                <div class="relative inline-block">
                    <img src="{{ $dish->image_url }}" alt="{{ $dish->name ?? 'Dish' }}"
                        class="w-48 h-48 object-cover rounded-lg border-2 border-slate-300">
                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">
                        Current
                    </div>
                </div>
            </div>
        @endif

        <!-- File Upload Area -->
        <div class="mb-4">
            <label for="image" class="cursor-pointer block">
                <div
                    class="border-2 border-dashed border-amber-400 rounded-lg p-8 text-center hover:bg-amber-50 transition">
                    <svg class="w-12 h-12 mx-auto text-amber-500 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-slate-700 font-semibold mb-1">Click to upload dish image</p>
                    <p class="text-sm text-slate-500">PNG, JPG or WEBP (Max 5MB)</p>
                </div>
                <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/jpg,image/webp"
                    @change="previewImage" class="hidden" {{ isset($dish) ? '' : 'required' }}>
            </label>
            @error('image')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Preview -->
        <div x-show="imageUrl" class="mt-4">
            <p class="text-sm text-slate-600 mb-2">New Image Preview:</p>
            <div class="relative inline-block">
                <img :src="imageUrl" alt="Preview"
                    class="w-48 h-48 object-cover rounded-lg border-2 border-amber-500">
                <div class="absolute top-2 right-2 bg-amber-500 text-slate-900 px-2 py-1 rounded text-xs font-bold">
                    New
                </div>
            </div>
            <button type="button" @click="clearImage" class="ml-4 text-red-600 hover:text-red-800 font-semibold">
                Remove
            </button>
        </div>

        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800">
                <strong>📸 Image Tips:</strong>
            </p>
            <ul class="text-sm text-blue-700 mt-2 space-y-1 ml-4 list-disc">
                <li>Use high-quality, well-lit photos</li>
                <li>Recommended size: 800x800 pixels</li>
                <li>Show the dish clearly from a good angle</li>
                <li>Keep file size under 5MB</li>
            </ul>
        </div>
    </div>
</div>

<script>
    function imageUpload() {
        return {
            imageUrl: null,

            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        event.target.value = '';
                        return;
                    }

                    // Validate file type
                    const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a PNG, JPG, or WEBP image');
                        event.target.value = '';
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            clearImage() {
                this.imageUrl = null;
                document.getElementById('image').value = '';
            }
        }
    }
</script>
