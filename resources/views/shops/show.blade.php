@extends('layouts.app')

@section('title', $gown->name . ' | GownEase')

@section('content')

<style>
    .product-detail {
        max-width: 1100px;
        margin: 45px auto;
    }

    .product-detail-image {
        width: 100%;
        max-height: 760px;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        background: #f0edf2;
    }

    .product-detail-info {
        padding: 20px 10px;
    }

    .product-detail-info h1 {
        font-family: Georgia, serif;
        font-size: clamp(32px, 4vw, 46px);
        color: #30234a;
    }

    .product-detail-price {
        font-size: 27px;
        font-weight: 600;
        margin: 20px 0;
    }

    .detail-label {
        color: #81738b;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
    }

    .detail-value {
        margin-bottom: 18px;
    }

    .gown-quantity {
        width: 100px;
        min-height: 48px;
        border: 1px solid #d8d0df;
        padding: 10px;
    }

    .gown-add-cart {
        background: #30234a;
        color: #fff;
        border: 1px solid #30234a;
        min-height: 48px;
        transition: background .2s ease;
    }

    .gown-add-cart:hover {
        background: #513878;
        color: #fff;
    }

    .gown-secondary-btn {
        border: 1px solid #30234a;
        color: #30234a;
        background: #fff;
        min-height: 48px;
    }

    .gown-secondary-btn:hover {
        background: #f1edf6;
        color: #30234a;
    }
</style>

<div class="container product-detail">
    <a href="{{ route('shop') }}"
       class="text-decoration-none text-secondary">
        ← Back to Collection
    </a>

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-warning mt-3">
        {{ session('error') }}
    </div>
@endif

<div class="row g-5 mt-2">
    <div class="col-12 col-md-6">
        @if($gown->image)
            <img
                src="{{ asset('storage/' . $gown->image) }}"
                alt="{{ $gown->name }}"
                class="product-detail-image"
            >
        @else
            <div class="product-detail-image d-flex align-items-center justify-content-center">
                No photo available
            </div>
        @endif
    </div>

    <div class="col-12 col-md-6">
        <div class="product-detail-info">
            <p class="detail-label">{{ $gown->category }}</p>

            <h1>{{ $gown->name }}</h1>

            <div class="product-detail-price">
                ₱{{ number_format((float) $gown->rental_price, 2) }}
                <span class="fs-6 fw-normal text-secondary">
                    rental price
                </span>
            </div>

            <hr>

            <p class="detail-label">Availability</p>
            <p class="detail-value">
                <span class="badge text-bg-success">Available</span>
            </p>

            <p class="detail-label">Color</p>
            <p class="detail-value">{{ $gown->color }}</p>

            <p class="detail-label">Size</p>
            <p class="detail-value">{{ $gown->size }}</p>

            @if((float) $gown->deposit_price > 0)
                <p class="detail-label">Security Deposit</p>
                <p class="detail-value">
                    ₱{{ number_format((float) $gown->deposit_price, 2) }}
                </p>
            @endif

            @if($gown->description)
                <p class="detail-label">About This Item</p>
                <p class="detail-value">{{ $gown->description }}</p>
            @endif

            <hr>

            <form action="{{ route('cart.add', $gown) }}"
                  method="POST" class="mt-4">
                @csrf

                <label for="quantity" class="form-label fw-semibold">
                    Quantity
                </label>

                <div class="d-flex flex-wrap gap-3">
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="gown-quantity"
                        value="1"
                        min="1"
                        max="10"
                        required
                    >

                    <button type="submit"
                            class="btn gown-add-cart px-4 grow">
                        🛒 Add to Cart
                    </button>
                </div>

                <small class="text-secondary d-block mt-2">
                    Choose up to 10 items per product.
                </small>
            </form>

            <a href="{{ route('shop') }}"
               class="btn gown-secondary-btn rounded-0 px-4 mt-3 w-100">
                Continue Exploring
            </a>

            <a href="{{ route('cart.index') }}"
               class="btn btn-link text-secondary mt-2">
                View Shopping Cart →
            </a>
        </div>
    </div>
</div>

</div>
@endsection