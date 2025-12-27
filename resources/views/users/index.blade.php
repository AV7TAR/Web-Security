@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card app-card border-0">
            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-dark-subtle text-uppercase brand-pill text-secondary mb-1">
                            User management
                        </span>
                        <h3 class="fw-bold mb-0">Users</h3>
                    </div>

                    <div class="d-flex align-items-center">
                        <form method="get" action="{{ route('users.index') }}" class="d-flex me-3">
                            <input type="text"
                                   name="keywords"
                                   class="form-control form-control-sm me-2"
                                   placeholder="Search by name or email"
                                   value="{{ request('keywords') }}">
                            <button class="btn btn-sm btn-outline-secondary">
                                Search
                            </button>
                        </form>

                        @can('edit_users')
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                                + Add user
                            </a>
                        @endcan
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach ($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th style="width: 260px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->roles->pluck('name')->join(', ') }}</td>
                                <td>
                                    @if (auth()->user()->can('edit_users')
                                        || auth()->user()->can('edit_user_name_only')
                                        || auth()->id() == $u->id)
                                        <a href="{{ route('users.edit', $u) }}"
                                           class="btn btn-sm btn-outline-primary me-1 mb-1">
                                            Edit
                                        </a>
                                    @endif

                                    <a href="{{ route('users.password_form', $u) }}"
                                       class="btn btn-sm btn-outline-secondary me-1 mb-1">
                                        Change password
                                    </a>

                                    @can('delete_users')
                                        <a href="{{ route('users.delete', $u) }}"
                                           class="btn btn-sm btn-outline-danger mb-1"
                                           onclick="return confirm('Delete this user?');">
                                            Delete
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
