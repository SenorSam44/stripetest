@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-inline-flex justify-content-between">
                        <span class="text-capitalize text-monospace font-weight-bold" style="font-size: 20px">plans</span>
                        <a href="{{ route('plan.show', 'new') }}" class="btn btn-primary"> Create Plan</a>

                    </div>
                    <div class="card-body">

                        <ul class="list-group">
                            @foreach($plans as $key => $plan)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>
                                        <h5>{{ $products[$key]->name }}</h5>
                                        <h5>${{ number_format($plan->amount, 2) }} monthly</h5>
                                        <h5>{{ $plan->description }}</h5>
                                        <a href="{{ route('subscription.show', $plan->id) }}" class="btn btn-outline-dark pull-right">Choose</a>
                                    </div>

                                    <div>
                                        <a href="{{route('plan.show', $plan->id)}}" class="btn btn-info"> Edit </a>
                                        <a href="#" class="btn btn-danger"> Delete </a>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
