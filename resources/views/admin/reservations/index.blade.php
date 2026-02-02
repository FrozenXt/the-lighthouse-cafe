<!-- resources/views/admin/reservations/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Reservations Management')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-serif font-bold text-slate-800 mb-2">Reservations Management</h2>
        <p class="text-slate-600">Manage customer table reservations</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Pending</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $reservations->where('status', 'pending')->count() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Confirmed</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $reservations->where('status', 'confirmed')->count() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <p class="text-slate-600 text-sm font-semibold mb-1">Cancelled</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b-2 border-slate-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Customer</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Contact</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Date & Time</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Guests</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Status</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800">{{ $reservation->name }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-slate-600">{{ $reservation->email }}</p>
                                <p class="text-sm text-slate-600">{{ $reservation->phone }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-800">{{ $reservation->date->format('M d, Y') }}</p>
                                <p class="text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-lg">{{ $reservation->guests }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.reservations.update-status', $reservation) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                        class="px-3 py-2 rounded-lg text-sm font-semibold border-2 cursor-pointer {{ $reservation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($reservation->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed"
                                            {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled"
                                            {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.reservations.delete', $reservation) }}" method="POST"
                                    onsubmit="return confirm('Delete this reservation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @if ($reservation->special_requests)
                            <tr class="bg-slate-50">
                                <td colspan="6" class="py-2 px-6">
                                    <p class="text-sm text-slate-600"><strong>Special Requests:</strong>
                                        {{ $reservation->special_requests }}</p>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-500">
                                <p class="text-lg font-semibold">No reservations found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-200 bg-slate-50">
            {{ $reservations->links() }}
        </div>
    </div>
@endsection
