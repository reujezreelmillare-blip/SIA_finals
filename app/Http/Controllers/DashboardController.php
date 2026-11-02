<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gown;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Customers go directly to the clothing shop
        if (! $user->isAdmin()) {
            return redirect()->route('shop');
        }

        // Admin dashboard statistics
        $stats = [
            'gowns' => Gown::count(),
            'customers' => User::where('role', 'customer')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'active' => Booking::whereIn(
                'status',
                ['approved', 'active']
            )->count(),
            'income' => Payment::where('status', 'paid')->sum('amount'),
        ];

        // Latest bookings
        $recentBookings = Booking::with(['user', 'gown'])
            ->latest()
            ->take(10)
            ->get();

        return view(
            'dashboard.admin',
            compact('stats', 'recentBookings')
        );
    }
}
