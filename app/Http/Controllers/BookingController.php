
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Display all rental bookings.
     */
    public function index()
    {
        $bookings = DB::table('bookings')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->leftJoin('gowns', 'gowns.id', '=', 'bookings.gown_id')
            ->select(
                'bookings.*',
                'users.name as customer_name',
                'users.email as customer_email',
                'gowns.name as gown_name'
            )
            ->latest('bookings.created_at')
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display one booking.
     */
    public function show($id)
    {
        $booking = DB::table('bookings')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->leftJoin('gowns', 'gowns.id', '=', 'bookings.gown_id')
            ->select(
                'bookings.*',
                'users.name as customer_name',
                'users.email as customer_email',
                'gowns.name as gown_name',
                'gowns.rental_price'
            )
            ->where('bookings.id', $id)
            ->first();

        abort_if(!$booking, 404);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'approved', 'active']),
            ],
        ]);

        $booking = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$booking) {
            abort(404);
        }

        DB::table('bookings')
            ->where('id', $id)
            ->update([
                'status' => $validated['status'],
                'updated_at' => now(),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Booking status updated successfully!');
    }
}
