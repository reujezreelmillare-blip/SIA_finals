
@extends('layouts.app')

@section('content')
<div class="container py-5">

    
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Product Management</h1>
        <p class="text-muted mb-0">
            Manage your gowns, dresses, suits, and clothing products.
        </p>

        <a href="{{ route('dashboard') }}"
           class="btn btn-outline-secondary mt-3">
            ← Return to Dashboard
        </a>
    </div>

    <a href="{{ route('admin.gowns.create') }}"
       class="btn btn-dark btn-lg">
        + Add Product
    </a>
</div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="p-3">Photo</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Rental Price</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gowns as $gown)
                            <tr>
                                <td class="p-3">
                                    @if($gown->image)
                                        <img
                                            src="{{ asset('storage/' . $gown->image) }}"
                                            alt="{{ $gown->name }}"
                                            width="65"
                                            height="75"
                                            style="object-fit: cover; border-radius: 8px;"
                                        >
                                    @else
                                        <span class="text-muted">No photo</span>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $gown->name }}</strong>
                                    <div class="small text-muted">
                                        {{ $gown->color }} · Size {{ $gown->size }}
                                    </div>
                                </td>

                                <td>{{ $gown->category }}</td>

                                <td>
                                    ₱{{ number_format($gown->rental_price, 2) }}
                                </td>

                                <td>
                                    @if($gown->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @elseif($gown->status === 'unavailable')
                                        <span class="badge bg-secondary">Unavailable</span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ ucfirst($gown->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a
                                            href="{{ route('admin.gowns.edit', $gown) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.gowns.destroy', $gown) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h5>No products added yet</h5>
                                    <p class="text-muted">
                                        Start by adding your first clothing product.
                                    </p>

                                    <a href="{{ route('admin.gowns.create') }}"
                                       class="btn btn-dark">
                                        + Add Your First Product
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $gowns->links() }}
    </div>

</div>
@endsection
