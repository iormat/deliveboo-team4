<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Dish;
use App\Customer;


class OrderController extends Controller
{
    public function generate(Request $request, Gateway $gateway){
        $token = $gateway -> clientToken() -> generate();
        $data = [
            'success' => true,
            'token' => $token
        ];
     
        return response()->json($data, 200);
    }
    

    public function makePayment(OrderRequest $request, Gateway $gateway){
        $total = $request -> total;
        $result = $gateway->transaction()->sale([
            'amount' => $total,
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
        return response()->json($total);
    }


    public function customerInfo(Request $request) {
        // validate required customer info data
        $data = $request -> validate ([
            'name' => 'required | string | min:2 | max:60',
            'surname' => 'required | string | min:2 | max:60',
            'address' => 'required| string | min:4 | max:60',
            'note' => 'string | min:4 | max:60',
            'cap' => 'required | string | min:5 | max:5',  
            'telephone' => 'required | string',      
        ]);

        $customer = Customer::create($data);
 
        return json_encode($customer);
    } 
}
