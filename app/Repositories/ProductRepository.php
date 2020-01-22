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

    public function update($attributes, Product $product)
    {
        
        $product->name = $attributes->name;
        $product->rrp_cny = $attributes->rrp_cny;
        $product->ref_price_aud = $attributes->ref_price_aud;
        $product->save();
        return $product;
    }

    public function delete(Product $product)
    {

    }
}