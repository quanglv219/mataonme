@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">Add a user</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="form-group">
                    <label class="w-100">Name
                        <input class="form-control" name="name">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Email
                        <input class="form-control" name="email">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Username
                        <input class="form-control" name="username">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Password
                        <input type="password" class="form-control" name="password">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">
                        <input type="checkbox" name="is_admin" value="1" class="custom-control-input" id="customSwitch1"> Admin
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection