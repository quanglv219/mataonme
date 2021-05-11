@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('admin.users.create') }}" id="addUserButton" class="btn btn-dark" onclick="showAddUser()">
        Create new user
    </a>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Users</h3>
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">#</th>
                                <th class="border-top-0">Name</th>
                                <th class="border-top-0">Username</th>
                                <th class="border-top-0">Email</th>
                                <th class="border-top-0">Joined</th>
                                <th class="border-top-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }} @if($user->is_admin) <span class="font-weight-bold text-success">Admin</span> @endif</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" style="display: inline-block">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-danger text-light" onclick="if(confirm('Are you sure?')) { this.type = 'submit' } else { event.stopImmediatePropagation() }"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $users->links() }}
@endsection