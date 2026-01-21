<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('membership.index');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string',
            'membership_tier' => 'required|in:bronze,silver,gold,platinum',
        ]);

        $validated['join_date'] = now();
        $validated['points'] = 0;

        Member::create($validated);

        return redirect()->route('membership')
                       ->with('success', 'Welcome to The Lighthouse Cafe family!');
    }
}
