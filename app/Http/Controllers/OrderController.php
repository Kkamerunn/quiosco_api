<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OrderCollection(Order::with('user')->with('products')->where('state', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Save order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->total = $request->total;
        $order->save();

        // Get the order id
        $id = $order->id;

        // Get the products
        $products = $request->products;

        // Format Array
        $order_product = [];

        foreach($products as $product) {
            $order_product[] = [
                'order_id' => $id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Save in the DB
        OrderProduct::insert($order_product);

        return [
            'message' => 'Order made successfully, you are getting it in a few minutes'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->state = 1;
        $order->save();

        return [
            'order' => $order
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
