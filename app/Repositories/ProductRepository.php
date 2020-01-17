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

    public function update(Product $product)
    {
        $p = Product::find($product->id);
        $p->rrp_cny = $product->rrp_cny;
        $p->ref_price_aud = $product->ref_price_aud;
        return $p->save();
    }

    public function delete(Product $product)
    {

    }
}