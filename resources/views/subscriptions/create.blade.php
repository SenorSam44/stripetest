@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('plan.index')}}"> < Back</a>
        <div class="card" style="width:24rem;margin:auto;"  >
            <div class="card-header">
                @if(isset($product->name))
                    Edit {{$product->name}}
                @else
                    Create new product
                @endif
            </div>
            <div class="card-body">
                <form action="{{route('plan.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="plan name">Product Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Plan Name" value="{{isset($product->name)? $product->name: ""}}">
                    </div>
                    <div class="form-group">
                        <label for="cost">Plan Cost:</label>
                        <input type="number" class="form-control" name="cost" placeholder="Enter Cost" value="{{isset($plan->amount)? $plan->amount: ""}}">
                    </div>

                    <div class="form-group">
                        <label for="cost">Plan Interval:</label>
                        <input type="text" class="form-control" name="interval" placeholder="Enter Interval" value="{{isset($plan->interval)? $plan->interval: ""}}">
                    </div>

                    <div class="form-group">
                        <label for="cost">Plan Currency:</label>
                        <input type="text" class="form-control" name="currency" placeholder="Enter Currency" value="{{isset($plan->currency)? $plan->currency: "eur"}}">
                    </div>

                    <input type="hidden" name="plan_id" value="{{isset($plan->id)? $plan->id: null}}">
                    <input type="hidden" name="product_id" value="{{isset($product->id)? $product->id: null}}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
