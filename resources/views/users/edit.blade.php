@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card app-card border-0">
            <div class="card-body p-4 p-md-5">

                <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-2">
                    User details
                </span>
                <h3 class="fw-bold mb-3">
                    {{ $isNew ? 'Create user' : 'Edit user: '.$user->name }}
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

                <form method="post" action="{{ route('users.save', $isNew ? null : $user) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full name</label>
                        <input name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    @if ($current->can('edit_users'))
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input name="email"
                                   type="email"
                                   class="form-control"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                        </div>

                        @if ($isNew)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Initial password</label>
                                <input name="password"
                                       type="password"
                                       class="form-control"
                                       required>
                                <div class="form-text">
                                    User can change it later from "Change password".
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Roles</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($allRoles as $roleName)
                                    <div class="form-check me-3 mb-1">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="roles[]"
                                               value="{{ $roleName }}"
                                               id="role_{{ $roleName }}"
                                               {{ in_array($roleName, old('roles', $userRoles)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $roleName }}">
                                            {{ ucfirst($roleName) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-muted">
                            You can only change your name. Other fields are restricted.
                        </p>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            Back
                        </a>
                        <button class="btn btn-primary">
                            Save user
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
