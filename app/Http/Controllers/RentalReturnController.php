
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RentalReturnController extends Controller
{
    /**
     * Display all rental returns.
     */
    public function index()
    {
        $returns = DB::table('rental_returns')
            ->join('bookings', 'rental_returns.booking_id', '=', 'bookings.id')
            ->leftJoin('gowns', 'bookings.gown_id', '=', 'gowns.id')
            ->select(
                'rental_returns.*',
                'bookings.user_id',
                'bookings.gown_id',
                'bookings.start_date',
                'bookings.end_date',
                'gowns.name as gown_name'
            )
            ->latest('rental_returns.created_at')
            ->paginate(15);

        return view('admin.returns.index', compact('returns'));
    }

    /**
     * Record a gown rental return.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'returned_at' => 'required|date',
            'condition' => [
                'required',
                Rule::in(['good', 'damaged', 'lost']),
            ],
            'late_fee' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $booking = DB::table('bookings')
            ->where('id', $validated['booking_id'])
            ->first();

        if (!$booking) {
            abort(404);
        }

        if (!in_array($booking->status, ['approved', 'active', 'completed'])) {
            return back()->with(
                'error',
                'Only approved or active bookings can be returned.'
            );
        }

        $existingReturn = DB::table('rental_returns')
            ->where('booking_id', $booking->id)
            ->exists();

        if ($existingReturn) {
            return back()->with(
                'error',
                'A return record already exists for this booking.'
            );
        }

        DB::transaction(function () use ($validated, $booking) {

            DB::table('rental_returns')->insert([
                'booking_id' => $booking->id,
                'returned_at' => $validated['returned_at'],
                'condition' => $validated['condition'],
                'late_fee' => $validated['late_fee'],
                'notes' => $validated['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('bookings')
                ->where('id', $booking->id)
                ->update([
                    'status' => 'completed',
                    'updated_at' => now(),
                ]);
        });

        return back()->with(
            'success',
            'Rental return recorded successfully!'
        );
    }
}
