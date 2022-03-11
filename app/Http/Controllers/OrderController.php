<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Customer;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Dish;
use App\Mail\PaymentConfirmation;
use Illuminate\Support\Facades\Mail;




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
            'email' => 'required | string | min:2 | max:60',
            'address' => 'required| string | min:4 | max:60',
            'note' => 'string | min:4 | max:60',
            'cap' => 'required | string | min:5 | max:5',
            'telephone' => 'required | string',
        ]);

        $customer = Customer::create($data);
 
        return json_encode($customer);
    }

    public function createOrder(Request $request) {
        
        $data = $request -> validate ([
            "total_price" => 'required',
            "payment_confirmation" => 'required',
            "date" => 'required | string',
        ]);
        $data['confirmed'] = 0;
        $data['confirmation_date'] = "1977-04-03";
  


        
        $order = Order::make($data);
        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        $order -> customer() -> associate($lastCustomer);
        $order -> save();

        for($i = 0; $i < count(array_keys($request -> all())) - 3; $i++) {
            $key = "dish";
            $key .= strval($i);
            $dish = Dish::findOrFail($request -> $key);

            $order -> dishes() -> attach($dish);
        };




        $user = DB::table('orders') 
                -> select('users.*')
                -> join('dish_order', 'orders.id', '=', 'dish_order.order_id')
                -> join('dishes',  'dish_order.dish_id', '=', 'dishes.id',)
                -> join('users', 'dishes.user_id', '=', 'users.id')
                -> where('orders.id', '=', $order -> id)
                -> get();

        $userEmail = $user[0] -> email;    
        

        Mail::to($lastCustomer -> email) -> send(new PaymentConfirmation($order));
        Mail::to($userEmail) -> send(new PaymentConfirmation($order));

        return json_encode($order);
    }

    public function index(){
        return view('pages.orders');
    }

    public function list() {
        
        $user = Auth::user();

        $orders = DB::table('orders') 
        //-> select('*')
        -> select('orders.created_at', 'orders.total_price', 'dishes.user_id', 'customers.name', 'customers.surname', 'customers.address', 'orders.id', 'orders.confirmed')
        -> distinct()
        -> join('customers', 'customer_id', '=', 'customers.id')
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> get();

        return response()->json($orders);    
    }

    public function confirm(Request $request){
        $id = key($request -> all());       
        $order = Order::findOrFail($id);
        $order['confirmed'] = 1;
        $order -> update();

        return response()->json($order);
    }
}
