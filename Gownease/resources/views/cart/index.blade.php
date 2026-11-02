```blade
@extends('layouts.app')

@section('title', 'Shopping Cart | GownEase')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <p class="text-uppercase small" style="letter-spacing: 3px; color: #B79A78;">
            GownEase Collection
        </p>
        <h1 style="font-family: 'Playfair Display', serif; color: #30263A;">
            Your Shopping Cart
        </h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($items->isEmpty())
        <div class="text-center py-5" style="background: #F8F5F0;">
            <h4>Your cart is empty.</h4>
            <p class="text-secondary">Explore our collection and find your next outfit.</p>
            <a href="{{ route('shop') }}" class="btn btn-dark mt-2">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach ($items as $item)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center g-3">
                                <div class="col-4 col-md-3">
                                    @if ($item->image)
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}"
                                            class="img-fluid rounded"
                                            style="width: 100%; height: 150px; object-fit: cover;"
                                        >
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded"
                                             style="height: 150px; background: #F8F5F0;">
                                            No image
                                        </div>
                                    @endif
                                </div>

                                <div class="col-8 col-md-9">
                                    <h5 style="color: #30263A;">{{ $item->name }}</h5>

                                    <p class="text-secondary small mb-1">
                                        {{ $item->category }} · {{ $item->color }} · Size {{ $item->size }}
                                    </p>

                                    <p class="fw-semibold">
                                        ₱{{ number_format((float) $item->rental_price, 2) }}
                                    </p>

                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <form action="{{ route('cart.update', $item->id) }}"
                                              method="POST"
                                              class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PATCH')

                                            <label for="quantity-{{ $item->id }}" class="small">
                                                Quantity
                                            </label>

                                            <input
                                                id="quantity-{{ $item->id }}"
                                                type="number"
                                                name="quantity"
                                                min="1"
                                                max="10"
                                                value="{{ $item->cart_quantity }}"
                                                class="form-control"
                                                style="width: 80px;"
                                                required
                                            >

                                            <button type="submit" class="btn btn-outline-dark btn-sm">
                                                Update
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.remove', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Remove this product from your cart?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-link text-danger btn-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </div>

                                    <p class="mt-3 mb-0">
                                        Subtotal:
                                        <strong>
                                            ₱{{ number_format((float) $item->cart_subtotal, 2) }}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <strong>₱{{ number_format((float) $total, 2) }}</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span>Total</span>
                            <strong style="color: #30263A; font-size: 20px;">
                                ₱{{ number_format((float) $total, 2) }}
                            </strong>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="btn btn-dark w-100">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('shop') }}"
                           class="btn btn-outline-secondary w-100 mt-2">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
```