<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use \App\Models\Plan;

class SubscriptionController extends Controller
{
    protected $stripe;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
        return view('plans.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = Plan::find($request->plan);
        $stripeProduct = $this->stripe->products->create([
            'name' => $plan->name,
        ]);

        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $plan->cost,
            'currency' => env('CASHIER_CURRENCY'),
            'interval' => 'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);


        Plan::create([
            'name' => $plan->name,
            'slug' => $plan->name.Carbon::now(),
            'cost' => $plan->cost,
            'stripe_plan' => $stripePlanCreation->id,
        ]);

        return redirect(route('plan.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $plan = Plan::find($request->plan);

        $user = $request->user();

        $paymentMethod = $request->paymentMethod;

        $stripeCustomer = $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->newSubscription('default', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);

        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
