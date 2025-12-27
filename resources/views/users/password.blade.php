@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card app-card border-0">
            <div class="card-body p-4 p-md-5">

                <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-2">
                    Security
                </span>
                <h3 class="fw-bold mb-3">
                    Change password – {{ $user->name }}
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

                <form method="post" action="{{ route('users.password_save', $user) }}">
                    @csrf

                    @if (!$current->can('change_any_password'))
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current password</label>
                            <input name="old_password"
                                   type="password"
                                   class="form-control"
                                   required>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">New password</label>
                        <input name="password"
                               type="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm new password</label>
                        <input name="password_confirmation"
                               type="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            Back
                        </a>
                        <button class="btn btn-primary">
                            Update password
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
