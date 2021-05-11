@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">Website settings</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                <div class="form-group">
                    <label class="w-100">Name
                        <input class="form-control" name="name" value="{{ $settings->name ?? old('name') ?? '' }}">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Description
                        <input class="form-control" name="description" value="{{ $settings->description ?? old('description') ?? '' }}">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Keywords <small>(must be separated with comma)</small>
                        <input class="form-control" name="keywords" value="{{ $settings->keywords ?? old('keywords') ?? '' }}">
                    </label>
                </div>
                <div class="form-group">
                    <label class="w-100">Logo <small>(URL)</small>
                        <input class="form-control" name="logo" value="{{ $settings->logo ?? old('logo') ?? '' }}">
                    </label>
                </div>
                <button class="btn btn-primary">Save settings</button>
            </form>
        </div>
    </div>
@endsection