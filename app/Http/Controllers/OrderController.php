<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;


class OrderController extends Controller
{
    public function generate(Request $request, Gateway $gateway){
        $token = $gateway->clientToken()->generate();
        $data = [
            'success' => true,
            'token' => $token
        ];
     
        return response()->json($data, 200);
    }

    public function makePayment(OrderRequest $request, Gateway $gateway){
        $result = $gateway->transaction()->sale([
            'dish' => '15.00',
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if($result->success){
            $data = [
                'success' => true,
                'message' => 'Transazione completata'
            ];
            return response()->json($data, 200);
        }else{
            $data = [
                'success' => false,
                'message' => 'Transazione fallita'
            ];
         
            return response()->json($data, 200);
        }
        // return 'makePaymant';
    }
}
