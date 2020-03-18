<?php

namespace App\Http\Controllers;

use App\OrderItem;
use App\Order;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        return $order->items()->create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price_cny' => $request->unit_price_cny,
            'purchase_price_aud' => $request->purchase_price_aud,
            'exchange_rate' => $request->exchange_rate
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderItemModel  $orderItemModel
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderItemModel  $orderItemModel
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItemModel  $orderItemModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItemModel  $orderItemModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
    }
}
