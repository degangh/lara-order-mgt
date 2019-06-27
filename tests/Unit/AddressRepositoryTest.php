<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressRepositoryTest extends TestCase
{
    public function setup()
    {
        parent::setup();
        $this->customer = factory(\App\Customer::class)->create();
        $this->address = factory(\App\Address::class)->make(['customer_id' => $this->customer->id]);
        $this->addressRepository = new \App\Repositories\AddressRepository;
    }

    /** @test */
    public function a_new_address_can_be_added()
    {
        //given an existing customer in database, $this->customer

        //a new address can be added 
        $address = $this->addressRepository->create($this->address);
        $this->assertInstanceOf('\App\Address', $address);
    }
}
