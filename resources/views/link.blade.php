@extends('layouts.link')

@section('content')
    <link-page :user="{{ $user ?? User::where('username', request('username'))->first() }}" :auth="{{ auth()->user() ?? 'undefined' }}" website="{{ $website }}"></link-page>
@endsection