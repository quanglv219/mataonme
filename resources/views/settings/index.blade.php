@extends('layouts.app')

@section('content')
    <settings user="{{ getUserInfos() }}" current="{{ currentSubscription() }}"></settings>
@endsection