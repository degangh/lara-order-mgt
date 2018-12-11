<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
        $this->customer = factory(\App\Customer::class)->create();
    }
    
    /** @test */
    public function an_authenticated_user_may_create_order()
    {
        
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        
        //when the user created order
        $order = factory(\App\Order::class)->make([
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id
            ]
        );;
        $this->json('post', '/api/order', $order->toArray())
        ->assertStatus(200)
        ->assertJsonStructure([
            'user_id', 'customer_id', 'id', 'updated_at', 'created_at'
            ]);



        //the order should be visible in the database
    }

    /** @test */
    public function an_authenticated_user_may_add_order_itme()
    {
        //given an authenticated user
        //and a existing order
        //when the user adds order items to the order
        //the order items should be in the database
    }
}
