<?php
namespace App\Repositories\Contract;

interface CustomerRepositoryInterface
{
    /**
     * get list of records, default 20 records
     * 
     * @parmas record_per_page default 20
     * 
     * @return 
     */
    public function all($keyword, $record_per_page = 20);

    public function create($attributes);

    public function find($id);

    public function update(Customer $customer);

    public function delete(Customer $customer);
}