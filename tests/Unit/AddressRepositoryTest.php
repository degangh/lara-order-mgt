<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressRepositoryTest extends TestCase
{
    use WithFaker;
    
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

    /** @test */
    public function an_address_can_be_updated()
    {
        //given a customer and an existing address
        $address = $this->addressRepository->create($this->address);
        //and a set of updated address data
        $new_mobile = $this->faker->phoneNumber;
        $new_address = $this->faker->address;
        $new_postcode = $this->faker->postcode;
        $updated_address = factory(\App\Address::class)->make([
            'mobile' => $new_mobile,
            'address' => $new_address,
            'postcode' => $new_postcode,
        ]);

        $this->addressRepository->update($updated_address, $address);

        $this->assertDatabaseHas('addresses', array(
            'id' => $address->id,
            'mobile' => $new_mobile,
            'customer_id' => $address->customer_id,
            'address' => $new_address,
            'postcode' => $new_postcode
        ));
    }
}
