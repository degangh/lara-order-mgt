<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Customer;
use App\Address;

class CustomerTest extends TestCase
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
    function a_login_user_can_create_customer()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //when user create a customer record
        $response = $this->json('post', '/api/customer', array_merge($this->customer->toArray(),$this->address->toArray()))->assertStatus(200)
        ->assertJsonStructure(['id', 'name', 'name_py', 'mobile', 'id_no']);
        
        $customer = json_decode($response->getContent());

        //the new customer record can be returned from server in json format
        //and the new record can be seen in the database 
        $this->assertDatabaseHas('customers', [
            'name' => $this->customer->name,
            'mobile' => $this->customer->mobile
        ]);

        $this->assertDatabaseHas('addresses', [
            'customer_id' => $customer->id,
            'mobile' => $this->customer->mobile,
            'address' => $this->address->address
        ]);

        

    }

    /** @test */
    function an_unauthenticated_user_cannot_create_customer()
    {
        //given an unauthenticated user

        //when user is trying to create a customer record
        $customer = factory(\App\Customer::class)->make();

        $this->json('post', '/api/customer' , $customer->toArray())->assertStatus(401);
        //a 403 error should be returned
    }

    /** @test */
    function an_authenticated_user_can_get_customer_list()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //when user request customer list
        //an collection of customer should be returned
        $this->json('get', '/api/customer')->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id' , 'name' , 'name_py', 'addresses'
            ]
        ]); 
        
        
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
        $this->json('post' , '/api/address', $address->toArray())->assertStatus(200)->assertJsonStructure([
 
                'id', 'customer_id','address'

        ]);
    }

    /** @test */
    function an_login_user_can_set_default_address()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //and an existing customer with multiple addresses (3 in this test case)
        $customer = factory(\App\Customer::class)->create();
        $addresses = factory(\App\Address::class, 3)->create(['mobile'=>$customer->mobile, 'customer_id' => $customer->id]);
        //user is able to specify one of the address as default
        $this->json('patch', '/api/address/default', [
            'address_id'=>$address[0]->id,
            'customer_id' => $customer->id,
            'is_default' => 1
            ])->assertStatus(200);
        //and there should be one and only one default address for each customer
    }

    

}
