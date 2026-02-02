<!-- resources/views/admin/members/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Members Management')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-serif font-bold text-slate-800 mb-2">Members Management</h2>
        <p class="text-slate-600">Manage membership accounts and benefits</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-orange-100 text-sm font-semibold mb-1">Bronze Members</p>
            <h3 class="text-3xl font-bold">{{ $members->where('membership_tier', 'bronze')->count() }}</h3>
        </div>
        <div class="bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-gray-100 text-sm font-semibold mb-1">Silver Members</p>
            <h3 class="text-3xl font-bold">{{ $members->where('membership_tier', 'silver')->count() }}</h3>
        </div>
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-yellow-100 text-sm font-semibold mb-1">Gold Members</p>
            <h3 class="text-3xl font-bold">{{ $members->where('membership_tier', 'gold')->count() }}</h3>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <p class="text-blue-100 text-sm font-semibold mb-1">Platinum Members</p>
            <h3 class="text-3xl font-bold">{{ $members->where('membership_tier', 'platinum')->count() }}</h3>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b-2 border-slate-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Member</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Contact</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Tier</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Points</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Join Date</th>
                        <th class="text-left py-4 px-6 font-bold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800">{{ $member->name }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-slate-600">{{ $member->email }}</p>
                                <p class="text-sm text-slate-600">{{ $member->phone }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $tierColors = [
                                        'bronze' => 'bg-orange-100 text-orange-800',
                                        'silver' => 'bg-gray-100 text-gray-800',
                                        'gold' => 'bg-yellow-100 text-yellow-800',
                                        'platinum' => 'bg-blue-100 text-blue-800',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-bold {{ $tierColors[$member->membership_tier] }}">
                                    {{ ucfirst($member->membership_tier) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-lg text-amber-600">{{ $member->points }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-slate-600">{{ $member->join_date->format('M d, Y') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $member->id }}, '{{ $member->membership_tier }}', {{ $member->points }})"
                                        class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.members.delete', $member) }}" method="POST"
                                        onsubmit="return confirm('Delete this member?')">
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
                            <td colspan="6" class="text-center py-12 text-slate-500">
                                <p class="text-lg font-semibold">No members found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-200 bg-slate-50">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div id="editMemberModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-8">
            <h3 class="text-2xl font-serif font-bold text-slate-800 mb-6">Edit Member</h3>
            <form id="editMemberForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-slate-700 font-semibold mb-2">Membership Tier</label>
                    <select name="membership_tier" id="editTier"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500">
                        <option value="bronze">Bronze</option>
                        <option value="silver">Silver</option>
                        <option value="gold">Gold</option>
                        <option value="platinum">Platinum</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Points</label>
                    <input type="number" name="points" id="editPoints" min="0"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500">
                </div>
                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold py-3 rounded-lg transition">
                        Update
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 rounded-lg transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, tier, points) {
            document.getElementById('editMemberForm').action = `/admin/members/${id}`;
            document.getElementById('editTier').value = tier;
            document.getElementById('editPoints').value = points;
            document.getElementById('editMemberModal').classList.remove('hidden');
            document.getElementById('editMemberModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editMemberModal').classList.add('hidden');
            document.getElementById('editMemberModal').classList.remove('flex');
        }
    </script>
@endsection
