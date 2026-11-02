
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Welcome to GownEase!</h2>
            <p class="text-muted">Hello, {{ auth()->user()->name }}. Manage your gown rentals here.</p>
        </div>
        <a href="{{ route('logout') }}"
           class="btn btn-outline-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>My Bookings</h5>
                    <h2>{{ $bookings->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Pending Bookings</h5>
                    <h2>{{ $bookings->where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Approved Bookings</h5>
                    <h2>{{ $bookings->where('status', 'approved')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">My Recent Bookings</h5>
        </div>
        <div class="card-body">
            @if($bookings->isEmpty())
                <p class="text-muted mb-0">You haven't made any bookings yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Gown</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->gown->name ?? 'Gown unavailable' }}</td>
                                    <td>{{ $booking->start_date }}</td>
                                    <td>{{ $booking->end_date }}</td>
                                    <td>₱{{ number_format($booking->total_price, 2) }}</td>
                                    <td>{{ ucfirst($booking->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection
