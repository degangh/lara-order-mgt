<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Customer;

class CustomerTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
        $this->customer = factory(\App\Customer::class)->make();
    }
    
    /** @test */
    function a_login_user_can_create_customer()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //when user create a customer record
        $this->json('post', '/api/customer', $this->customer->toArray())->assertStatus(200)
        ->assertJsonStructure(['id', 'name', 'name_py', 'mobile', 'id_no']);
        $this->assertDatabaseHas('customers', [
            'name' => $this->customer->name,
            'mobile' => $this->customer->mobile
        ]);
        //the new customer record can be returned from server in json format
        //and the new record can be seen in the database
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
                'id' , 'name' , 'name_py'
            ]
        ]); 
        
        
    }

}
