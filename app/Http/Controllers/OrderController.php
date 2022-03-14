<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


use App\Customer;
use App\Order;
use App\Dish;

use App\Mail\PaymentCustomerMail;
use App\Mail\PaymentUserMail;


class OrderController extends Controller {
    // generate customer token
    public function generate(Request $request, Gateway $gateway){
        $token = $gateway -> clientToken() -> generate();
        $data = [
            'success' => true,
            'token' => $token
        ];
     
        return response()->json($data, 200);
    }
    // validate payments
    public function makePayment(OrderRequest $request, Gateway $gateway){
        $total = $request -> total;
        $result = $gateway->transaction()->sale([
            'amount' => $total,
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        // handling results
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

    // validate required customer info data
    public function customerInfo(Request $request) {
        $data = $request -> validate ([
            'name' => 'required | string | min:2 | max:60',
            'surname' => 'required | string | min:2 | max:60',
            'email' => 'required | string | min:2 | max:60',
            'address' => 'required| string | min:5 | max:60',
            'note' => 'nullable| string | max:255',
            'cap' => 'required | string | min:5 | max:5',
            'telephone' => 'required | string',
        ]);
        $customer = Customer::create($data);
 
        return json_encode($customer);
    }

    // create new order
    public function createOrder(Request $request) { 
        $data = $request -> validate ([
            "total_price" => 'required',
            "payment_confirmation" => 'required',
            "date" => 'required | string',
        ]);
        $data['confirmed'] = 0;
        $data['confirmation_date'] = "1977-04-03";
  
        // make order
        $order = Order::make($data);
        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        // associate customer to order
        $order -> customer() -> associate($lastCustomer);
        $order -> save();
        // order manipulation for DB
        $requestKeys = array_keys($request -> all());
        $nDishes = [];
        // take only dishes from order
        for ($i = 0; $i < count($requestKeys); $i++) {
            if(strpos($requestKeys[$i], "dish") !== false) {
                array_push($nDishes, $requestKeys[$i]);
            }
        }

        $dishes = [];
        // create DB association through pivot
        for($i = 0; $i < count($nDishes) ; $i++) {
            $parolaDish = "dish";
            $parolaQuantity ="quantity";
            $key = strval($i);

            $dishId = $parolaDish .= $key;
            $dishQuantity =  $parolaQuantity .= $i;

            $dish = Dish::findOrFail($request -> $dishId);
            array_push($dishes, $dish);
            $dishQuantity = $request -> $dishQuantity;
            $dishes[$i]['quantity'] = $dishQuantity;

            DB::table('dish_order') -> insert([
                ['dish_id' => $dish -> id, 'order_id' => $order -> id, 'amount' => $dishQuantity]
            ]);
        };
        // get relative user info based on dishes in order
        $user = DB::table('orders') 
                -> select('users.*')
                -> join('dish_order', 'orders.id', '=', 'dish_order.order_id')
                -> join('dishes',  'dish_order.dish_id', '=', 'dishes.id',)
                -> join('users', 'dishes.user_id', '=', 'users.id')
                -> where('orders.id', '=', $order -> id)
                -> get();
        // get only user info
        $user = $user[0];  

        // send order confirmation to user and customer
        Mail::to($lastCustomer -> email) -> send(new PaymentCustomerMail($order, $lastCustomer, $dishes));
        Mail::to($user -> email) -> send(new PaymentUserMail($order, $lastCustomer, $user, $dishes));

        return json_encode($order);
    }

    // return orders page
    public function index(){
        return view('pages.orders');
    }

    // get all authenticated user orders
    public function list() {  

        $orders = Order::with('dishes', 'customer')
            -> whereHas('dishes', function($query) {
                $user = Auth::user();
                $id = $user -> id;
                $query->where('user_id', $id);
            })
            ->orderBy('orders.id', 'desc')
            -> get();

        return response()->json($orders);    
    }
    // user order confirmation
    public function confirm(Request $request){
        $id = key($request -> all());       
        $order = Order::findOrFail($id);
        $order['confirmed'] = 1;
        $order -> update();

        return response()->json($order);
    }
}
