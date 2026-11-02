
@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 800px;">
    <h2>Add Clothing Item</h2>
    <p class="text-muted">Enter the product information and upload a photo.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gowns.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="card card-body">
        @csrf

        <label class="form-label">Clothing Name</label>
        <input name="name" class="form-control mb-3"
               value="{{ old('name') }}" required>

        <label class="form-label">Category</label>
        <select name="category" class="form-select mb-3" required>
            @foreach(['Gown', 'Wedding Dress', 'Formal Dress', 'Suit', 'Costume', 'Other'] as $category)
                <option value="{{ $category }}" @selected(old('category', 'Gown') === $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control mb-3">{{ old('description') }}</textarea>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Size</label>
                <input name="size" class="form-control mb-3"
                       value="{{ old('size') }}" placeholder="S, M, L, XL" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Color</label>
                <input name="color" class="form-control mb-3"
                       value="{{ old('color') }}" required>
            </div>
        </div>

        <label class="form-label">Rental Price (₱)</label>
        <input type="number" name="rental_price" class="form-control mb-3"
               min="0" step="0.01" value="{{ old('rental_price') }}" required>

        <label class="form-label">Security Deposit (₱)</label>
        <input type="number" name="deposit_price" class="form-control mb-3"
               min="0" step="0.01" value="{{ old('deposit_price', '0') }}">

        <label class="form-label">Clothing Photo</label>
        <input type="file" name="image" class="form-control mb-3"
               accept="image/jpeg,image/png,image/webp" required>

        <label class="form-label">Availability</label>
        <select name="status" class="form-select mb-4" required>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="maintenance">Under Maintenance</option>
        </select>

        <button class="btn btn-primary">Save Clothing Item</button>
        <a href="{{ route('admin.gowns.index') }}" class="btn btn-light mt-2">Cancel</a>
    </form>
</div>
@endsection
