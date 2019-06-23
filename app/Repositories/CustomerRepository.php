<?php

namespace App\Repositories;
use App\Repositories\Contract\CustomerRepositoryInterface;
use App\Customer;


class CustomerRepository implements CustomerRepositoryInterface
{
    public function all($records_per_page = 20)
    {
        return Customer::with(array(
            'addresses' => function ($query){
                $query->orderBy('is_default', 'desc');
            }))->paginate(20);
    }

    public function create($attributes)
    {
        
        return Customer::create([
            'name' => $attributes->name,
            'name_py' => $attributes->name_py,
            'mobile' => $attributes->mobile,
            'id_no' => $attributes->id_no
        ]);
        
    }

    public function find($id)
    {

    }
}