@extends('admin.layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="inbox-header mb-4">

        <div>
            <h2 class="title">Contact Inbox</h2>
            <p class="subtitle">All customer messages in one place</p>
        </div>

        <div class="stats-box">
            <div class="label">Total Messages</div>
            <div class="value">{{ $contacts->total() }}</div>
        </div>

    </div>

    {{-- SEARCH BAR --}}
    <div class="inbox-toolbar mb-3">

        <form method="GET" class="toolbar-form">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search name, email, subject...">

            <select name="filter">
                <option value="">All</option>
                <option value="today" {{ request('filter')=='today'?'selected':'' }}>Today</option>
                <option value="week" {{ request('filter')=='week'?'selected':'' }}>This Week</option>
                <option value="month" {{ request('filter')=='month'?'selected':'' }}>This Month</option>
            </select>

            <button type="submit">Search</button>

            <a href="{{ route('admin.contacts.index') }}">Reset</a>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="inbox-card">

        <table class="inbox-table">

            <thead>
                <tr>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($contacts as $contact)

                    <tr class="inbox-row">

                        {{-- USER --}}
                        <td>
                            <div class="user">
                                <div class="avatar">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="name">{{ $contact->name }}</div>
                                    <div class="status-dot"></div>
                                </div>
                            </div>
                        </td>

                        {{-- SUBJECT --}}
                        <td>
                            <span class="subject">
                                {{ $contact->subject }}
                            </span>
                        </td>

                        {{-- MESSAGE --}}
                        <td class="message">
                            {{ \Illuminate\Support\Str::limit($contact->message, 70) }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="email">
                            {{ $contact->email }}
                        </td>

                        {{-- DATE --}}
                        <td class="date">
                            {{ $contact->created_at->format('d M Y') }}
                            <div class="time">
                                {{ $contact->created_at->diffForHumans() }}
                            </div>
                        </td>

                        {{-- ACTION --}}
                        <td class="actions">

                            <a href="{{ route('admin.contacts.show', $contact->id) }}">
                                Open
                            </a>

                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete message?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit">Delete</button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="empty">
                            No messages found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $contacts->links() }}
    </div>

</div>

{{-- STYLE --}}
<style>

body {
    background: #f5f7fb;
}

.inbox-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title {
    font-size: 22px;
    font-weight: 700;
}

.subtitle {
    font-size: 13px;
    color: #777;
}

.stats-box {
    background: #fff;
    padding: 10px 18px;
    border-radius: 10px;
    border: 1px solid #eee;
    text-align: center;
}

.stats-box .label {
    font-size: 12px;
    color: #888;
}

.stats-box .value {
    font-size: 18px;
    font-weight: 700;
    color: #2563eb;
}

.inbox-toolbar {
    background: #fff;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #eee;
}

.toolbar-form {
    display: flex;
    gap: 10px;
}

.toolbar-form input,
.toolbar-form select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 8px;
    flex: 1;
}

.toolbar-form button {
    background: #111;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
}

.toolbar-form a {
    padding: 8px 14px;
    background: #eee;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
}

.inbox-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #eee;
    overflow: hidden;
}

.inbox-table {
    width: 100%;
    border-collapse: collapse;
}

.inbox-table thead {
    background: #fafafa;
    font-size: 12px;
    color: #777;
}

.inbox-table th,
.inbox-table td {
    padding: 14px;
    border-bottom: 1px solid #f0f0f0;
}

.inbox-row:hover {
    background: #f9fbff;
}

.user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.avatar {
    width: 38px;
    height: 38px;
    background: #2563eb;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 600;
}

.name {
    font-weight: 600;
}

.status-dot {
    width: 6px;
    height: 6px;
    background: #22c55e;
    border-radius: 50%;
    margin-top: 3px;
}

.subject {
    background: #eef2ff;
    color: #4f46e5;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
}

.message {
    color: #666;
    font-size: 13px;
}

.email {
    font-size: 13px;
    color: #333;
}

.date {
    font-size: 13px;
}

.time {
    font-size: 11px;
    color: #888;
}

.actions {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.actions a {
    font-size: 12px;
    padding: 6px 10px;
    background: #e0f2fe;
    color: #0369a1;
    border-radius: 6px;
    text-decoration: none;
}

.actions button {
    font-size: 12px;
    padding: 6px 10px;
    background: #fee2e2;
    color: #b91c1c;
    border: none;
    border-radius: 6px;
}

.empty {
    text-align: center;
    padding: 30px;
    color: #888;
}

</style>

@endsection
