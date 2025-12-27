@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card app-card border-0 text-center">
            <div class="card-body p-5">
                <div class="display-4 mb-3">403</div>
                <h3 class="fw-bold mb-2">Access denied</h3>
                <p class="text-muted mb-4">
                    You don’t have permission to view this page.
                    If you believe this is a mistake, please contact the system administrator.
                </p>

                <a href="{{ route('home') }}" class="btn btn-primary me-2">
                    Back to dashboard
                </a>

                <a href="{{ route('do_logout') }}" class="btn btn-outline-secondary btn-sm">
                    Log in with another account
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
