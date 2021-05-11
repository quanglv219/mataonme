@extends('layouts.app')

@section('content')
    <plans :user="{{ auth()->user() }}"></plans>
@endsection