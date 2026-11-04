@extends('layouts.app')

@section('title', 'Shop Collection | GownEase')

@section('content')
<style>
    .shop-page {
        color: #302B32;
    }

    .shop-hero {
        background: #F8F5F0;
        padding: 42px 24px;
        text-align: center;
        margin-bottom: 30px;
    }

    .shop-eyebrow {
        color: #B79A78;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 11px;
        font-weight: 600;
    }

    .shop-heading {
        font-family: 'Playfair Display', serif;
        color: #30263A;
        font-size: clamp(30px, 4vw, 46px);
        margin: 8px 0;
    }

    .shop-description {
        color: #777078;
        max-width: 600px;
        margin: 0 auto;
    }

    .filter-panel {
        border: 1px solid #E8E0D8;
        background: #fff;
        padding: 22px;
        margin-bottom: 30px;
    }

    .filter-panel label {
        font-size: 12px;
        color: #51415F;
        margin-bottom: 6px;
    }

    .filter-panel .form-control,
    .filter-panel .form-select {
        border-radius: 3px;
        min-height: 43px;
    }

    .collection-heading {
        font-family: 'Playfair Display', serif;
        color: #30263A;
    }

    .product-card {
        height: 100%;
        border: 1px solid #E8E0D8;
        background: white;
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(48, 38, 58, .10);
    }

    .product-image-wrap {
        position: relative;
        overflow: hidden;
        background: #F8F5F0;
    }

    .product-image {
        display: block;
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.025);
    }

    .product-image-placeholder {
        width: 100%;
        aspect-ratio: 3 / 4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777078;
        background: #F8F5F0;
    }

    .product-info {
        padding: 16px;
    }

    .product-category {
        color: #B79A78;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 10px;
        font-weight: 600;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        color: #30263A;
        text-decoration: none;
    }

    .product-name:hover {
        color: #B79A78;
    }

    .product-meta {
        color: #777078;
        font-size: 12px;
    }

    .product-price {
        font-weight: 600;
        font-size: 16px;
        color: #30263A;
    }

    .shop-button {
        display: block;
        width: 100%;
        padding: 10px;
        background: #30263A;
        border: 1px solid #30263A;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 12px;
        letter-spacing: .5px;
    }

    .shop-button:hover {
        background: #51415F;
        border-color: #51415F;
        color: white;
    }

    .empty-products {
        border: 1px solid #E8E0D8;
        padding: 50px 20px;
        text-align: center;
        background: #F8F5F0;
    }

    .empty-products h3 {
        font-family: 'Playfair Display', serif;
        color: #30263A;
    }

    .pagination {
        margin-top: 30px;
    }

    .page-link {
        color: #30263A;
        border-color: #E8E0D8;
    }

    .active > .page-link,
    .page-link.active {
        background: #30263A;
        border-color: #30263A;
        color: white;
    }
</style>

<div class="shop-page">

    {{-- Collection heading --}}
    <section class="shop-hero">
        <div class="shop-eyebrow">GownEase Collection</div>

        <h1 class="shop-heading">
            Find Your Perfect Look
        </h1>

        <p class="shop-description">
            Explore our collection of gowns, suits, and special-occasion
            outfits for your next memorable event.
        </p>
    </section>

    {{-- Filters --}}
    <section class="filter-panel">
        <form action="{{ route('shop') }}" method="GET" id="shop-filter-form">
            <div class="row g-3 align-items-end">

                <div class="col-12 col-md-6 col-lg-4">
                    <label for="search" class="form-label">Search products</label>

                    <input
                        type="search"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Search by name, color, size..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-6 col-md-6 col-lg-2">
                    <label for="category" class="form-label">Category</label>

                    <select
                        name="category"
                        id="category"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Categories</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category }}"
                                @selected(request('category') === $category)
                            >
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="color" class="form-label">Color</label>

                    <select
                        name="color"
                        id="color"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Colors</option>

                        @foreach ($colors as $color)
                            <option
                                value="{{ $color }}"
                                @selected(request('color') === $color)
                            >
                                {{ $color }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="size" class="form-label">Size</label>

                    <select
                        name="size"
                        id="size"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Sizes</option>

                        @foreach ($sizes as $size)
                            <option
                                value="{{ $size }}"
                                @selected(request('size') === $size)
                            >
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="sort" class="form-label">Sort by</label>

                    <select
                        name="sort"
                        id="sort"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="">Newest</option>
                        <option value="name" @selected(request('sort') === 'name')>
                            Name
                        </option>
                        <option value="price_low" @selected(request('sort') === 'price_low')>
                            Price: Low to High
                        </option>
                        <option value="price_high" @selected(request('sort') === 'price_high')>
                            Price: High to Low
                        </option>
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="min_price" class="form-label">
                        Minimum price (₱)
                    </label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        name="min_price"
                        id="min_price"
                        class="form-control"
                        value="{{ request('min_price') }}"
                        placeholder="0"
                    >
                </div>

                <div class="col-6 col-md-4">
                    <label for="max_price" class="form-label">
                        Maximum price (₱)
                    </label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        name="max_price"
                        id="max_price"
                        class="form-control"
                        value="{{ request('max_price') }}"
                        placeholder="No limit"
                    >
                </div>

                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark grow">
                        Apply Filters
                    </button>

                    <a href="{{ route('shop') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </section>

    {{-- Product results --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h2 class="collection-heading mb-1">
                @if (request()->filled('category'))
                    {{ request('category') }}
                @else
                    Our Collection
                @endif
            </h2>

            <p class="text-secondary mb-0">
                {{ $gowns->total() }}
                {{ $gowns->total() === 1 ? 'item' : 'items' }} found
            </p>
        </div>

        @if (request()->filled('category'))
            <a href="{{ route('shop') }}"
               class="text-decoration-none small">
                Clear category filter &times;
            </a>
        @endif
    </div>

    @if ($gowns->count() > 0)
        <div class="row g-4">
            @foreach ($gowns as $gown)
                <div class="col-6 col-md-4 col-lg-3">
                    <article class="product-card">

                        <div class="product-image-wrap">
                            <a href="{{ route('shop.show', $gown) }}">
                                @if ($gown->image)
                                    <img
                                        src="{{ asset('storage/' . $gown->image) }}"
                                        alt="{{ $gown->name }}"
                                        class="product-image"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="product-image-placeholder">
                                        No image available
                                    </div>
                                @endif
                            </a>
                        </div>

                        <div class="product-info">
                            <div class="product-category mb-1">
                                {{ $gown->category }}
                            </div>

                            <a href="{{ route('shop.show', $gown) }}"
                               class="product-name">
                                {{ $gown->name }}
                            </a>

                            <p class="product-meta mt-2 mb-2">
                                {{ $gown->color }} · Size {{ $gown->size }}
                            </p>

                            <div class="product-price mb-3">
                                ₱{{ number_format((float) $gown->rental_price, 2) }}
                                <span class="product-meta fw-normal">
                                    / rental
                                </span>
                            </div>

                            <a href="{{ route('shop.show', $gown) }}"
                               class="shop-button">
                                VIEW DETAILS
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $gowns->links() }}
        </div>
    @else
        <div class="empty-products">
            <h3>No matching products found</h3>

            <p class="text-secondary">
                There are no available products matching your selected
                category and filters.
            </p>

            <a href="{{ route('shop') }}" class="btn btn-dark mt-2">
                View All Products
            </a>
        </div>
    @endif

</div>
@endsection
