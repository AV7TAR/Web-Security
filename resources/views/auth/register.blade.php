@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="card app-card border-0">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-2">
                        New here?
                    </span>
                    <h3 class="fw-bold mb-1">Create an account</h3>
                    <p class="text-muted mb-0">Register to start using the supermarket system.</p>
                </div>

                @if (!empty($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('do_register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full name</label>
                        <input
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            name="email"
                            type="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input
                            name="passwor
