@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card app-card border-0 text-center">
            <div class="card-body p-5">
                <div class="display-4 mb-3">404</div>
                <h3 class="fw-bold mb-2">Page not found</h3>
                <p class="text-muted mb-4">
                    The page you’re looking for doesn’t exist or has been moved.
                </p>

                <a href="{{ auth()->check() ? route('home') : route('login') }}" class="btn btn-primary">
                    Back to dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
