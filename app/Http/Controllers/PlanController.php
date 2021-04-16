<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PlanController extends Controller
{

    protected $stripe;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
//        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
        $this->stripe = new StripeClient("sk_test_51IgRgmLdDBaVtjVPPhF0Cjjd4PAZtHIm3IRQPFxovVSxnZNk6fpasjEsTVNayED7Qrmu0KcpVSJSI4rg1Cr3K6ew003sQq4M9I");

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $plans = $this->stripe->plans->all()->data;
        $products = $this->stripe->products->all()->data;
        return view('plans.index')
            ->with('products', $products)
            ->with('plans', $plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */

    public function store(Request $request)
    {
        if ($request->slug!="new"){
            $plan = Plan::where('slug', $request->slug)->first();
            $stripeProduct = $this->stripe->products->update(
                $request->product_id,
                [
                    'name' => $plan->name,
                ]);

            $stripePlanUpdate = $this->stripe->plans->update(
                $plan->stripe_plan,
                [ 'metadata'=>[
                    'amount' => $plan->cost,
                    'currency' => $request->currency,
                    'interval' => 'month', //  it can be day,week,month or year
                    'product' => $stripeProduct->id,
                ]

                ]);


            Plan::where('slug', $plan->slug)->update([
                'name' => $plan->name,
                'cost' => $plan->cost,
                'slug' =>  $stripeProduct->id,
                'stripe_plan' => $stripePlanUpdate->id,
            ]);
            return redirect(route('plan.index'));

        }else{
            $stripeProduct = $this->stripe->products->create([
                'name' => $request->name,
            ]);

            $stripePlanCreation = $this->stripe->plans->create([
                'amount' => $request->cost,
                'currency' => $request->currency,
                'interval' => 'month', //  it can be day,week,month or year
                'product' => $stripeProduct->id,
            ]);


            Plan::create([
                'name' => $request->name,
                'slug' => $stripeProduct->id,
                'cost' => $request->cost,
                'stripe_plan' => $stripePlanCreation->id,
            ]);
            return redirect(route('plan.index'));

        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        if ($slug== "new")
            return view('plans.create');

        $plan = $this->stripe->plans->retrieve($slug);
        $product = $this->stripe->products->retrieve($plan->product);
        return view('plans.create')
            ->with('plan', $plan)
            ->with('product', $product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->stripe->plans->cancel($id);

        return redirect()->back();
    }
}
