<?php

namespace App\Repositories;
use App\Repositories\Contract\ProductRepositoryInterface;
use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {
        return Product::when($keyword, function($query, $keyword){
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->paginate(20);

    }

    public function create($attributes)
    {
        
        return Product::create([
            'name' => $attributes->name,
            'ref_price_aud' => $attributes->ref_price_aud,
            'rrp_cny' => $attributes->rrp_cny
        ]);
        
    }

    public function update($attributes)
    {
        $p = Product::find($attributes->id);
        $p->name = $attributes->name;
        $p->rrp_cny = $attributes->rrp_cny;
        $p->ref_price_aud = $attributes->ref_price_aud;
        $p->save();
        return $p;
    }

    public function delete(Product $product)
    {

    }
}