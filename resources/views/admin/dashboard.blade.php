@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total users</h3>
                <ul class="list-inline two-part d-flex align-items-center mb-0">
                    <li>
                        <p class="h2 text-info"><i class="fa fa-users"></i></p>
                    </li>
                    <li class="ms-auto"><span class="counter text-info">{{ $users->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total Links Clicks</h3>
                <ul class="list-inline two-part d-flex align-items-center mb-0">
                    <li>
                        <p class="h2 text-success"><i class="fa fa-link"></i></p>
                    </li>
                    <li class="ms-auto"><span class="counter text-success">{{ $clicks }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total Links Views</h3>
                <ul class="list-inline two-part d-flex align-items-center mb-0">
                    <li>
                        <p class="h2 text-info text-purple"><i class="fa fa-eye"></i></p>
                    </li>
                    <li class="ms-auto"><span class="counter text-purple">{{ $views ?? 0 }}</span></li>
                </ul>
            </div>
        </div>
        </div>
    </div>
@endsection
