
@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 800px;">
    <h2>Edit Clothing Item</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gowns.update', $gown) }}"
          method="POST" enctype="multipart/form-data"
          class="card card-body">
        @csrf
        @method('PUT')

        <label class="form-label">Name</label>
        <input name="name" class="form-control mb-3"
               value="{{ old('name', $gown->name) }}" required>

        <label class="form-label">Category</label>
        <select name="category" class="form-select mb-3" required>
            @foreach(['Gown', 'Wedding Dress', 'Formal Dress', 'Suit', 'Costume', 'Other'] as $category)
                <option value="{{ $category }}"
                    @selected(old('category', $gown->category) === $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control mb-3">{{ old('description', $gown->description) }}</textarea>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Size</label>
                <input name="size" class="form-control mb-3"
                       value="{{ old('size', $gown->size) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Color</label>
                <input name="color" class="form-control mb-3"
                       value="{{ old('color', $gown->color) }}" required>
            </div>
        </div>

        <label class="form-label">Rental Price (₱)</label>
        <input type="number" name="rental_price" min="0" step="0.01"
               class="form-control mb-3"
               value="{{ old('rental_price', $gown->rental_price) }}" required>

        <label class="form-label">Security Deposit (₱)</label>
        <input type="number" name="deposit_price" min="0" step="0.01"
               class="form-control mb-3"
               value="{{ old('deposit_price', $gown->deposit_price) }}">

        @if($gown->image)
            <p>Current photo:</p>
            <img src="{{ asset('storage/'.$gown->image) }}"
                 alt="{{ $gown->name }}"
                 style="width: 150px; height: 150px; object-fit: cover;"
                 class="mb-3">
        @endif

        <label class="form-label">Replace Photo (optional)</label>
        <input type="file" name="image" class="form-control mb-3"
               accept="image/jpeg,image/png,image/webp">

        <label class="form-label">Status</label>
        <select name="status" class="form-select mb-4" required>
            @foreach(['available', 'unavailable', 'maintenance'] as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $gown->status) === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary">Update Clothing Item</button>
        <a href="{{ route('admin.gowns.index') }}" class="btn btn-light mt-2">Cancel</a>
    </form>
</div>
@endsection
