<?php
namespace App\Repositories\Contract;

interface OrderRepositoryInterface
{
    /**
     * get list of records, default 20 records
     * 
     * @parmas record_per_page default 20
     * 
     * @return 
     */
    public function all($record_per_page = 20);

    public function create($attributes);

}