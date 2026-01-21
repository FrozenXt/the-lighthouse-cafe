<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string',
        ]);

        Reservation::create($validated);

        return redirect()->route('home')
                       ->with('success', 'Reservation request submitted successfully!');
    }
}