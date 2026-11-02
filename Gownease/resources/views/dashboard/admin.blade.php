
@extends('layouts.app')

@section('title', 'Admin Dashboard | GownEase')

@section('content')
<h2 class="brand mb-1">Administrator Dashboard</h2>
<p class="text-secondary">Manage your gown rental business.</p>

{{-- Product Management Buttons --}}
<div class="d-flex flex-wrap gap-3 mb-4">
    <a href="{{ route('admin.gowns.index') }}"
       class="btn btn-primary px-4 py-2">
        Manage Products
    </a>

    <a href="{{ route('admin.gowns.create') }}"
       class="btn btn-success px-4 py-2">
        + Add Product
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg">
        <div class="content-card p-3">
            <p class="text-secondary mb-1">Total Gowns</p>
            <h3>{{ $stats['gowns'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-lg">
        <div class="content-card p-3">
            <p class="text-secondary mb-1">Customers</p>
            <h3>{{ $stats['customers'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-lg">
        <div class="content-card p-3">
            <p class="text-secondary mb-1">Pending Bookings</p>
            <h3>{{ $stats['pending'] }}</h3>
        </div>
    </div>

    <div class="col-6 col-lg">
        <div class="content-card p-3">
            <p class="text-secondary mb-1">Active Rentals</p>
            <h3>{{ $stats['active'] }}</h3>
        </div>
    </div>

    <div class="col-12 col-lg">
        <div class="content-card p-3">
            <p class="text-secondary mb-1">Recorded Income</p>
            <h3>₱{{ number_format((float) $stats['income'], 2) }}</h3>
        </div>
    </div>
</div>

<div class="content-card p-3 p-md-4">
    <h4>Recent Bookings</h4>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Gown</th>
                    <th>Rental Dates</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->gown->name }}</td>
                        <td>
                            {{ $booking->start_date->format('M d, Y') }}
                            –
                            {{ $booking->end_date->format('M d, Y') }}
                        </td>
                        <td>
                            ₱{{ number_format((float) $booking->total_price, 2) }}
                        </td>
                        <td>
                            <span class="badge text-bg-secondary">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary">
                            No bookings yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
