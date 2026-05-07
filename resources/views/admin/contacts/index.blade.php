@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
            <p class="text-sm text-gray-500">All messages sent from your website</p>
        </div>

        <div class="text-sm text-gray-500">
            Total: {{ $contacts->total() }}
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                {{-- Head --}}
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                {{ $contact->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $contact->email }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-50 text-blue-600">
                                    {{ $contact->subject }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                <p class="truncate" title="{{ $contact->message }}">
                                    {{ $contact->message }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $contact->created_at->format('Y-m-d') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gray-50 border-t">
            <div class="flex justify-end">
                {{ $contacts->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
