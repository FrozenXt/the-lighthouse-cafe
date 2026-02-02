<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.members.index', compact('members'));
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'membership_tier' => 'required|in:bronze,silver,gold,platinum',
            'points' => 'required|integer|min:0'
        ]);

        $member->update($validated);

        return back()->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted!');
    }
}
