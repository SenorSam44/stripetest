<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
//        $this->stripe = new StripeClient(env("STRIPE_SECRET"));

        $this->stripe = new StripeClient("sk_test_51IgRgmLdDBaVtjVPPhF0Cjjd4PAZtHIm3IRQPFxovVSxnZNk6fpasjEsTVNayED7Qrmu0KcpVSJSI4rg1Cr3K6ew003sQq4M9I");
    }

    public function index()
    {
        $subscriptions = $this->stripe->subscriptions->all() ;
        $products = array();
        foreach ($subscriptions as $subscription){
//            dd($subscription);
            array_push($products, $this->stripe->products->retrieve($subscription->plan->product));
        }

        return view('subscriptions.index')
            ->with('subscriptions', $subscriptions)
            ->with('products', $products);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Stripe\Exception\ApiErrorException
     */


    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $subscription = $this->stripe->subscriptions->retrieve($id);
//        dd($subscription);

        $product = $this->stripe->products->retrieve($subscription->plan->product);
        return view('subscriptions.show')
            ->with('subscription', $subscription)
            ->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */

    public function editSubscription(Request $request, $id){

        $this->stripe->subscriptions->update( $id, [
            'cancel_at_period_end' => $request->cancel_period_end,
        ]);

        return redirect()->back()->with('success', 'Subscription updated');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Stripe\Exception\ApiErrorException
     */

    public function deleteSubscription(Request $request, $id)
    {
        dd($id);
        $this->stripe->subscriptions->cancel(
            $id
        );

        return redirect(route('subscription.index'));
    }

    public function subscribe(Request $request, $plan_id){
        $plan = $this->stripe->plans->retrieve($plan_id);

//        dd($plan);
        $user = User::find(Auth::id());

        $paymentMethod = $request->payment_method;

        $stripeCustomer = $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);

        $user->newSubscription('default', $plan->id)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);

        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }
}
