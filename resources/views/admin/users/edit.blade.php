@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">Add a user</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="w-100">Name
                        <input class="form-control" name="name" value="{{ $user->name }}">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Email
                        <input class="form-control" name="email" value="{{ $user->email }}">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Username
                        <input class="form-control" name="username" value="{{ $user->username }}">
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection