<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use App\Customer;

class AddressController extends Controller
{
    /**
     * Display a listing of the address.
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
    public function store(Request $request)
    {
        $address = Address::create([
            "customer_id" => $request->customer_id,
            "address" => $request->address,
            "postcode" => $request->postcode,
            "mobile" => $request->mobile
        ]);

        $address->save();
        
        return response()->json($address->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }

    /**
     * set an address as default address of the user
     */
    public function setDefault(Request $request)
    {
        //set address owner's all address is_default = '0'
        $addresses = Address::where('customer_id', $request->customer_id)->get();

        foreach ($addresses as $a) 
        {
            if ($a->id != $request->id) $a->is_default = '0';
            else {

                $a->is_default = "1";
            }

            $a->save();
        }

        return Customer::with('addresses')->find($request->customer_id);

        
    }
}
