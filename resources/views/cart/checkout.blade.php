
@extends('layouts.app')

@section('title', 'Checkout | GownEase')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <p class="text-uppercase small" style="letter-spacing: 3px; color: #B79A78;">
            GownEase Collection
        </p>
        <h1 style="font-family: 'Playfair Display', serif; color: #30263A;">
            Complete Your Rental
        </h1>
        <p class="text-secondary">Choose your rental dates and preferred payment method.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($items->isEmpty())
        <div class="text-center py-5" style="background: #F8F5F0;">
            <h4>Your cart is empty.</h4>
            <a href="{{ route('shop') }}" class="btn btn-dark mt-3">Return to Shop</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Your Items</h5>

                        @foreach ($items as $item)
                            <div class="d-flex gap-3 align-items-center mb-4">
                                @if ($item->image)
                                    <img
                                        src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->name }}"
                                        class="rounded"
                                        style="width: 90px; height: 110px; object-fit: cover;"
                                    >
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                         style="width: 90px; height: 110px; background: #F8F5F0;">
                                        No image
                                    </div>
                                @endif

                                <div class="grow">
                                    <h6>{{ $item->name }}</h6>
                                    <p class="text-secondary small mb-1">
                                        {{ $item->category }} · {{ $item->color }} · Size {{ $item->size }}
                                    </p>
                                    <p class="small mb-1">Quantity: {{ $item->cart_quantity }}</p>
                                    <strong>₱{{ number_format((float) $item->cart_subtotal, 2) }}</strong>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between fs-5">
                            <span>Rental Total</span>
                            <strong style="color: #30263A;">
                                ₱{{ number_format((float) $total, 2) }}
                            </strong>
                        </div>
                        <p class="small text-secondary mt-2 mb-0">
                            Any applicable deposit or additional fees will be confirmed by the store.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Rental Details</h5>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="rental_start_date" class="form-label">
                                    Rental Start Date
                                </label>
                                <input
                                    type="date"
                                    id="rental_start_date"
                                    name="rental_start_date"
                                    class="form-control"
                                    min="{{ now()->toDateString() }}"
                                    value="{{ old('rental_start_date') }}"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="rental_end_date" class="form-label">
                                    Return Date
                                </label>
                                <input
                                    type="date"
                                    id="rental_end_date"
                                    name="rental_end_date"
                                    class="form-control"
                                    min="{{ now()->toDateString() }}"
                                    value="{{ old('rental_end_date') }}"
                                    required
                                >
                            </div>

                            <h6 class="mb-3">Payment Method</h6>

                            <label class="border rounded p-3 d-flex gap-3 align-items-start mb-3 w-100">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="gcash"
                                    class="form-check-input mt-1"
                                    @checked(old('payment_method', 'gcash') === 'gcash')
                                    required
                                >
                                <span>
                                    <strong>GCash</strong>
                                    <span class="d-block text-secondary small">
                                        Payment must be verified before the order is marked paid.
                                    </span>
                                </span>
                            </label>

                            <label class="border rounded p-3 d-flex gap-3 align-items-start mb-4 w-100">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="pay_at_store"
                                    class="form-check-input mt-1"
                                    @checked(old('payment_method') === 'pay_at_store')
                                    required
                                >
                                <span>
                                    <strong>Pay at Store</strong>
                                    <span class="d-block text-secondary small">
                                        Pay in person. The order remains unpaid until staff confirms payment.
                                    </span>
                                </span>
                            </label>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Due</span>
                                <strong>₱{{ number_format((float) $total, 2) }}</strong>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">
                                Submit Rental Request
                            </button>

                            <a href="{{ route('cart.index') }}"
                               class="btn btn-outline-secondary w-100 mt-2">
                                Back to Cart
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    const startDate = document.getElementById('rental_start_date');
    const endDate = document.getElementById('rental_end_date');

    if (startDate && endDate) {
        startDate.addEventListener('change', function () {
            endDate.min = this.value;

            if (endDate.value && endDate.value < this.value) {
                endDate.value = '';
            }
        });
    }
</script>
@endsection
```
