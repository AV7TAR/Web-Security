@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card app-card border-0">
            <div class="card-body p-4 p-md-5">

                <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-2">
                    Product details
                </span>
                <h3 class="fw-bold mb-3">
                    {{ $isNew ? 'Add product' : 'Edit product: '.$product->name }}
                </h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('products.save', $isNew ? null : $product) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input name="name"
                               class="form-control"
                               value="{{ old('name', $product->name) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <input name="category"
                               class="form-control"
                               value="{{ old('category', $product->category) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price</label>
                        <input name="price"
                               type="number"
                               step="0.01"
                               min="0"
                               class="form-control"
                               value="{{ old('price', $product->price) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Quantity in stock</label>
                        <input name="quantity"
                               type="number"
                               min="0"
                               class="form-control"
                               value="{{ old('quantity', $product->quantity) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  rows="4"
                                  class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            Back
                        </a>
                        <button class="btn btn-primary">
                            Save product
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
