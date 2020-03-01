<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Address;
use Illuminate\Http\Request;
use App\Repositories\Contract\CustomerRepositoryInterface;


class CustomerController extends Controller
{
    
    protected $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->customerRepository->all($request->keyword);
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
        $customer = $this->customerRepository->create($request);
        

        $address = Address::create([
            "customer_id" => $customer->id,
            "address" => $request->address,
            "postcode" => $request->postcode,
            "mobile" => $request->mobile,
            "is_default" => '1'
        ]);

        $address->save();

        return response()->json($customer->toArray());


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return Customer::with(array(
            'addresses' => function ($query){
                $query->orderBy('is_default', 'desc') ;
            })
        )->where('id',$customer->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function orders(Customer $customer)
    {
        return $this->customerRepository->orders($customer);
    }
}
