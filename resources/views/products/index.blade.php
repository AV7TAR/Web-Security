@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card app-card border-0">
            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-1">
                            Supermarket
                        </span>
                        <h3 class="fw-bold mb-0">Products</h3>
                    </div>

                    <div class="d-flex align-items-center">
                        <form method="get"
                              action="{{ route('products.index') }}"
                              class="d-flex me-3">
                            <input type="text"
                                   name="keywords"
                                   class="form-control form-control-sm me-2"
                                   placeholder="Search by name or category"
                                   value="{{ request('keywords') }}">
                            <input type="number"
                                   step="0.01"
                                   name="min_price"
                                   class="form-control form-control-sm me-2"
                                   placeholder="Min price"
                                   value="{{ request('min_price') }}">
                            <input type="number"
                                   step="0.01"
                                   name="max_price"
                                   class="form-control form-control-sm me-2"
                                   placeholder="Max price"
                                   value="{{ request('max_price') }}">
                            <button class="btn btn-sm btn-outline-secondary">
                                Filter
                            </button>
                        </form>

                        @can('create_products')
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                                + Add product
                            </a>
                        @endcan
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Quantity</th>
                                @canany(['edit_products', 'delete_products'])
                                    <th style="width: 200px;">Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($products as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->category }}</td>
                                <td class="text-end">{{ number_format($p->price, 2) }}</td>
                                <td class="text-end">{{ $p->quantity }}</td>
                                @canany(['edit_products', 'delete_products'])
                                    <td>
                                        @can('edit_products')
                                            <a href="{{ route('products.edit', $p) }}"
                                               class="btn btn-sm btn-outline-primary me-1 mb-1">
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete_products')
                                            <a href="{{ route('products.delete', $p) }}"
                                               class="btn btn-sm btn-outline-danger mb-1"
                                               onclick="return confirm('Delete this product?');">
                                                Delete
                                            </a>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
