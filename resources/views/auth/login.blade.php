@extends('layout')

@section('content')
<div class="d-flex justify-content-center align-items-center"
     style="min-height: calc(100vh - 72px);">
    <div class="card shadow-lg border-0 rounded-4" style="width: 420px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <span class="badge bg-primary-subtle text-primary text-uppercase mb-2"
                      style="letter-spacing: .12em;">
                    Welcome back
                </span>
                <h3 class="fw-bold mb-1">Sign in</h3>
                <p class="text-muted mb-0">
                    Log in to access the supermarket dashboard.
                </p>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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

            <form method="post" action="{{ route('do_login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        class="form-control form-control-lg"
                        required autofocus>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold d-flex justify-content-between">
                        <span>Password</span>
                    </label>
                    <input
                        name="password"
                        type="password"
                        class="form-control form-control-lg"
                        required>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Keep me signed in
                    </label>
                </div>

                <button class="btn btn-primary w-100 mt-4 btn-lg">
                    Log in
                </button>
            </form>

            <div class="text-center my-3">
                <span class="text-muted small">or</span>
            </div>

            <a href="{{ url('/auth/google/redirect') }}"
               class="btn btn-outline-dark w-100 btn-lg">
                <span class="me-2">🔐</span>
                Continue with Google
            </a>

        </div>
    </div>
</div>
@endsection
