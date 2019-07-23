<?php

namespace App\Repositories;
use App\Repositories\Contract\CustomerRepositoryInterface;
use App\Customer;


class CustomerRepository implements CustomerRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {
        
        return Customer::when($keyword, function($query, $keyword){
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->with(array(
            'addresses' => function ($query){
                $query->orderBy('is_default', 'desc');
        }))->paginate($records_per_page);
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