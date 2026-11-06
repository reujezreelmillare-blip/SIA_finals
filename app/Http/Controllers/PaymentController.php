
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display all payments.
     */
    public function index()
    {
        $payments = DB::table('payments')
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->leftJoin('gowns', 'bookings.gown_id', '=', 'gowns.id')
            ->select(
                'payments.*',
                'bookings.user_id',
                'bookings.gown_id',
                'bookings.status as booking_status',
                'gowns.name as gown_name'
            )
            ->latest('payments.created_at')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Create a payment record for a booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'payment_method' => [
                'required',
                Rule::in(['cash', 'gcash', 'bank_transfer']),
            ],
            'reference_number' => 'nullable|string|max:255',
        ]);

        $booking = DB::table('bookings')
            ->where('id', $validated['booking_id'])
            ->first();

        if (in_array($booking->status, ['rejected', 'cancelled'])) {
            return back()->with('error', 'This booking cannot receive payments.');
        }

        $existing = DB::table('payments')
            ->where('booking_id', $booking->id)
            ->first();

        if ($existing) {
            DB::table('payments')
                ->where('booking_id', $booking->id)
                ->update([
                    'payment_method' => $validated['payment_method'],
                    'reference_number' => $validated['reference_number'] ?? null,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('payments')->insert([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['reference_number'] ?? null,
                'status' => 'pending',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Payment record saved successfully!');
    }

    /**
     * Update payment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'paid', 'refunded']),
            ],
        ]);

        $payment = DB::table('payments')
            ->where('id', $id)
            ->first();

        if (!$payment) {
            abort(404);
        }

        DB::table('payments')
            ->where('id', $id)
            ->update([
                'status' => $validated['status'],
                'paid_at' => $validated['status'] === 'paid'
                    ? ($payment->paid_at ?? now())
                    : null,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Payment status updated successfully!');
    }
}
