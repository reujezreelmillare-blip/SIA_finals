```blade
@extends('layouts.app')

@section('title', 'Checkout | GownEase')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <p class="text-uppercase small" style="letter-spacing: 3px; color: #B79A78;">
            GownEase Collection
        </p>
        <h1 style="font-family: 'Playfair Display', serif; color: #30263A;">
            Checkout
        </h1>
        <p class="text-secondary">Review your selected products before confirming your order.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="fw-bold mb-1">Please check the following:</p>
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
            <a href="{{ route('shop') }}" class="btn btn-dark mt-3">
                Return to Shop
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Order Details</h5>

                        @foreach ($items as $item)
                            <div class="d-flex gap-3 align-items-center mb-4">
                                @if ($item->image)
                                    <img
                                        src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->name }}"
                                        style="width: 85px; height: 105px; object-fit: cover;"
                                        class="rounded"
                                    >
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                         style="width: 85px; height: 105px; background: #F8F5F0;">
                                        No image
                                    </div>
                                @endif

                                <div class="grow">
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <p class="text-secondary small mb-1">
                                        {{ $item->category }} · Size {{ $item->size }}
                                    </p>
                                    <p class="small mb-1">
                                        Quantity: {{ $item->cart_quantity }}
                                    </p>
                                    <strong>
                                        ₱{{ number_format((float) $item->cart_subtotal, 2) }}
                                    </strong>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between fs-5">
                            <span>Total</span>
                            <strong style="color: #30263A;">
                                ₱{{ number_format((float) $total, 2) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Confirm Your Order</h5>

                        <p class="text-secondary small">
                            Make sure your selected products and total are correct.
                        </p>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf

                            <div class="d-flex justify-content-between mb-3">
                                <span>Order total</span>
                                <strong>₱{{ number_format((float) $total, 2) }}</strong>
                            </div>

                            
<div class="mb-3">
    <label for="rental_start_date" class="form-label">
        Rental Start Date
    </label>
    <input type="date"
           name="rental_start_date"
           id="rental_start_date"
           class="form-control"
           min="{{ date('Y-m-d') }}"
           value="{{ old('rental_start_date') }}"
           required>
</div>

<div class="mb-3">
    <label for="rental_end_date" class="form-label">
        Return Date
    </label>
    <input type="date"
           name="rental_end_date"
           id="rental_end_date"
           class="form-control"
           min="{{ date('Y-m-d') }}"
           value="{{ old('rental_end_date') }}"
           required>
</div>

<div class="mb-4">
    <label class="form-label">Payment Method</label>

    <div class="form-check">
        <input class="form-check-input"
               type="radio"
               name="payment_method"
               id="gcash"
               value="gcash"
               {{ old('payment_method') == 'gcash' ? 'checked' : '' }}
               required>
        <label class="form-check-label" for="gcash">
            GCash
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input"
               type="radio"
               name="payment_method"
               id="pay_at_store"
               value="pay_at_store"
               {{ old('payment_method') == 'pay_at_store' ? 'checked' : '' }}>
        <label class="form-check-label" for="pay_at_store">
            Pay at Store
        </label>
    </div>
</div>


                            <button type="submit" class="btn btn-dark w-100">
                                Confirm Order
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
@endsection
```