<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Customer;
use App\Address;

class AddressTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
        $this->customer = factory(\App\Customer::class)->make();
        $this->address = factory(\App\Address::class)->make(['mobile'=>$this->customer->mobile]);
        //$this->withoutExceptionHandling();

    }

    /** @test */
    function an_login_user_can_add_address_to_existing_customer()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        //and an existing customer
        $customer = factory(\App\Customer::class)->create();
        $address = factory(\App\Address::class)->make(['mobile'=>$customer->mobile ,'customer_id' => $customer->id]);
        //user is able to add another address to this customer
        $this->json('post' , '/api/addresses', $address->toArray())->assertStatus(200)->assertJsonStructure([
 
                'id', 'customer_id','address'

        ]);
    }

    /** @test */
    function a_login_user_can_set_default_address()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //and an existing customer with multiple addresses (3 in this test case)
        $customer = factory(\App\Customer::class)->create();
        //with a default address
        $default_address = factory(\App\Address::class)->create(['mobile'=>$customer->mobile, 'customer_id' => $customer->id, 'is_default' => '1']);
        //and other 3 addresses
        $addresses = factory(\App\Address::class, 3)->create(['mobile'=>$customer->mobile, 'customer_id' => $customer->id]);
        //user is able to specify one of the address as default
        $this->json('patch', '/api/addresses/default', [
            'id'=>$addresses[0]->id,
            'customer_id' => $customer->id,
            'is_default' => "1"
            ])->assertStatus(200);
        
        //the address is set to default
        $this->assertDatabaseHas('addresses', array(
            'customer_id' => $customer->id,
            'address' => $addresses[0]->address,
            'is_default' => '1'
        ));

        //and there is only default address for this customer
        $count = \App\Address::where(
            [
                ['customer_id', $customer->id],
                ['is_default', "1"],
            ]
            )->count();
        $this->assertEquals($count,1);

        
    }
}
    