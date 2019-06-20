<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setup();

        $this->customer = factory(\App\Customer::class)->make();
        $this->customerRepository = new \App\Repositories\CustomerRepository;
    }
    
    
    /** @test */
    public function it_can_return_customer_list()
    {
        //given existing customer data in the database
        factory(\App\Customer::class, 10)->create();
        $customers = $this->customerRepository->all();
        //a pagination result of customer can be returned
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $customers);
        
    }

    /** @test */
    public function it_can_store_a_customer()
    {
        //give an object of customer
        $customer = $this->customerRepository->create($this->customer);
        
        //and returned as an object
        $this->assertInstanceOf('\App\Customer', $customer);

        //it can be saved into database
        $this->assertDatabaseHas('customers', array(
            'name' => $this->customer->name,
            'name_py' => $this->customer->name_py,
            'mobile' => $this->customer->mobile,
            'id_no' => $this->customer->id_no
        ));

        
    }

    public function it_can_get_individual_customer()
    {
        //give a customer data in the database
        //it's information can be retrieved by unique id
        //a customer object can be reurned
    }
}
