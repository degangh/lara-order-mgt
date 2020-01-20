<?php
namespace App\Repositories\Contract;
use App\Product;
interface ProductRepositoryInterface
{
    /**
     * get list of records, default 20 records
     * 
     * @parmas record_per_page default 20
     * 
     * @return 
     */
    public function all($record_per_page = 20);

    /**
     * create a product
     * 
     * @parmas record_per_page default 20
     * 
     * @return Bool
     */
    public function create($attributes);

    /**
     * update product
     * 
     * @parmas Product $product
     * 
     * @return Bool
     */
    public function update($attributes);

    /**
     * delete a product from database
     * 
     * @parmas Product $product
     * 
     * @return Bool
     */
    public function delete(Product $product);
}