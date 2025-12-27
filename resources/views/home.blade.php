@extends('layout')

@section('content')
@php
    /** @var \App\Models\User $user */
    $user = auth()->user();
@endphp

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h4 class="fw-bold mb-1">
                                Welcome, {{ $user->name }} 👋
                            </h4>
                            <p class="text-muted mb-0">
                                This is your supermarket control panel.
                            </p>
                        </div>
                        <div>
                            @if($user->hasRole('admin'))
                                <span class="badge bg-danger-subtle text-danger fw-semibold">
                                    Admin
                                </span>
                            @elseif($user->hasRole('employee'))
                                <span class="badge bg-warning-subtle text-warning fw-semibold">
                                    Employee
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success fw-semibold">
                                    Customer
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('products.index') }}"
                               class="text-decoration-none text-reset">
                                <div class="card h-100 border-0 bg-primary-subtle rounded-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-1">Supermarket Products</h5>
                                        <p class="text-muted mb-2">
                                            Browse, add, and manage products.
                                        </p>
                                        <span class="small fw-semibold text-primary">
                                            Go to products →
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @if($user->hasRole('admin') || $user->hasRole('employee'))
                            <div class="col-md-6">
                                <a href="{{ route('users.index') }}"
                                   class="text-decoration-none text-reset">
                                    <div class="card h-100 border-0 bg-info-subtle rounded-4">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-1">Manage Users</h5>
                                            <p class="text-muted mb-2">
                                                View accounts and roles for system users.
                                            </p>
                                            <span class="small fw-semibold text-info">
                                                Go to users →
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Quick info</h6>
                    <p class="mb-2">
                        <span class="text-muted">Logged in as:</span>
                        <span class="fw-semibold">{{ $user->email }}</span>
                    </p>
                    <p class="mb-3">
                        <span class="text-muted">Role:</span>
                        <span class="fw-semibold">
                            {{ $user->roles->pluck('name')->join(', ') ?: '—' }}
                        </span>
                    </p>

                    <a href="{{ route('do_logout') }}" class="btn btn-outline-danger w-100">
                        Log out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
