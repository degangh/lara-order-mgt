<?php

namespace App\Repositories;
use App\Repositories\Contract\ProductRepositoryInterface;
use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {
        if (empty($keyword)) return Product::paginate(20);

        return Product::where('name', 'like', '%' . $keyword . '%')->paginate(20);
    }

    public function create($attributes)
    {
        
        return Product::create([
            'name' => $attributes->name,
            'ref_price_aud' => $attributes->ref_price_aud
        ]);
        
    }
}