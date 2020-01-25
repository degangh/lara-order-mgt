<?php

namespace App\Repositories;
use App\Repositories\Contract\AddressRepositoryInterface;
use App\Address;


class AddressRepository implements AddressRepositoryInterface
{
    public function all($records_per_page = 20)
    {
        return true;
    }

    public function create($attributes)
    {
        
        return Address::create([
            "customer_id" => $attributes->customer_id,
            "address" => $attributes->address,
            "postcode" => $attributes->postcode,
            "mobile" => $attributes->mobile
        ]);
        
    }

    public function find($id)
    {
        return true;
    }

    public function update($attributes, Address $address)
    {

    }

    public function delete(Address $address){}
}