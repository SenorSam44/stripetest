@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-inline-flex justify-content-between">
                        <span class="text-capitalize text-monospace font-weight-bold" style="font-size: 20px">Subscription</span>
                    </div>
                    <div class="card-body">

                        <ul class="list-group">
                            @foreach($subscriptions as $key => $subscription)
                                <li class="list-group-item d-flex justify-content-between">

                                    <div>
                                        <h5>{{ $products[$key]->name }}</h5>
                                        <h5>{{ $subscription->amount }}</h5>
                                        <h5>${{ number_format($subscription->plan->amount, 2) }} {{$subscription->plan->interval}}ly</h5>
{{--                                        <a href="{{ route('plan.show', $subscription->id) }}" class="btn btn-outline-dark pull-right">Choose</a>--}}
                                    </div>

                                    <div>
                                        <a href="{{route('subscription.show', $subscription->id)}}" class="btn btn-info"> Edit </a>
                                        <form action="{{route('subscriptiondelete', $subscription->id)}}" method="post">
                                            <button type="submit" class="btn btn-danger"> Unsubscribe </button>
                                        </form>

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
