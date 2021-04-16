@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('subscription.index')}}"> < Back</a>
        <div class="card" style="width:24rem;margin:auto;">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{route('subscription.edit', $subscription->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cancel_period_end" id="exampleRadios2" value="false" checked>
                            <label class="form-check-label" for="exampleRadios2">
                                Do not cancel at period end
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cancel_period_end" id="exampleRadios1" value="true" {{$subscription->cancel_at_period_end? "checked": "unchecked"}}>
                            <label class="form-check-label" for="exampleRadios1">
                                Cancel at period end
                            </label>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="cost">Plan Currency:</label>
                        <input type="text" class="form-control" name="currency" placeholder="Enter Currency" value="{{isset($plan->currency)? $plan->currency: "eur"}}">
                    </div>

                    <input type="hidden" name="subscription_id" value="{{$subscription->id}}">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
