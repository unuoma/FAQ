<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('subscriptionpay');
    }

    public function charge(Request $request)
    {   $user = User::find(1);

        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            //'amount' => 'required',
        ]);
        $input = $request->all();
        if ($validator->passes()) {
            $input = array_except($input,array('_token'));
            $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    return redirect()->route('home')->with('message', 'Successfully subscribed');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => 20.49,
                    'description' => 'wallet',
                ]);

                if($charge['status'] == 'succeeded') {
                    echo "<pre>";
                    print_r($charge);exit();
                    return redirect()->route('home')->with('message', 'Updated Profile');
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return redirect()->route('home');
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('home');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('home');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('home');
            }
        }
        return redirect()->route('home')->with('message', 'Successfully subscribed. Look out for emails');

    }



    public function delete()
    {
        \Stripe\Stripe::setApiKey('sk_test_VChxmbzm6QoGhpI6RQWeaYyp00TLH02G5K');

        $subscription = \Stripe\Subscription::retrieve('sub_49ty4767H20z6a');
        $subscription->cancel();

    }

}
