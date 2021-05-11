@extends('layouts.app')

@section('content')
    <customization :user="{{ auth()->user() }}"></customization>
@endsection