@extends('admin.layouts.app')

@section('title', 'Add New Dish')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.dishes.index') }}"
                class="text-amber-600 hover:text-amber-700 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Menu
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-3xl font-serif font-bold text-slate-800 mb-6">Add New Dish</h2>

            <form action="{{ route('admin.dishes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.dishes.form')

                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold py-3 rounded-lg transition">
                        Add Dish
                    </button>
                    <a href="{{ route('admin.dishes.index') }}"
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 rounded-lg transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
