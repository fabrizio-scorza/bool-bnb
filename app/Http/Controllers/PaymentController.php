<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Plan;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;
use Braintree\Gateway as BraintreeGateway;
use Illuminate\Support\Facades\Session;

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
        $houseId = $request->houseId;
        $plan = Plan::where('price', $amount)->first();

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        if ($result->success) {
            $house = House::find($houseId);
            $house->plans()->attach($plan->id, [
            'created_at' => now(),
            'expires_at' => now()->addHours($plan->length),
        ]);

    // Imposta il messaggio di conferma nella sessione
    Session::flash('conferma', 'Pagamento avvenuto con successo!');

    // Costruisci l'URL di reindirizzamento alla pagina della casa
    $houseUrl = route('admin.houses.show', ['house' => $houseId]);

    // Ritorna un JSON con l'URL di reindirizzamento
    return response()->json(['success' => true, 'redirectUrl' => $houseUrl]);

        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }
}
