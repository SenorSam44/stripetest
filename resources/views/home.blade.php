@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome to the Dashboard

                        @auth
                            <div class="text-capitalize text-monospace font-weight-bold text-left mt-3"> plan</div>
                            <div class="d-flex justify-content-around mb-4">
                                <a href="{{ route('plan.show', 'new')  }}" class="btn btn-primary mt-3"> Create Plan</a>
                                <a href="{{ url('/plan') }}" class="btn btn-dark mt-3"> View Plans</a>
                            </div>

                                <div class="text-capitalize text-monospace font-weight-bold text-left mt-3"> Subscription</div>
                            <div class="d-flex justify-content-around mb-3">
                                <a href="{{ route('subscription.index') }}" class="btn btn-success mt-3"> View Subscription</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
