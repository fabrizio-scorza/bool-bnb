<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Plan;
use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new BraintreeGateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]);
    }

    public function token()
    {
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function checkout(Request $request)
    {
        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;
        $house = House::find($request->houseId);
        $plan = Plan::where('price', $amount)->first();

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        
        // $house->plans()->attach($plan, ['created_at' => now(), 'expires_at' => now()->addHours($plan->length)]);
        
        if ($result->success) {
            $house->plans()->attach(
                $plan->id,
                [
                    'created_at' => now(),
                    'expires_at' => now()->addHours($plan->length),
                ]
            );
            return response()->json(['success' => true, 'transaction' => $result->transaction]);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
        
    }
}

