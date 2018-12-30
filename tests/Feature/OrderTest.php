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
        );

        //the order should be visible in the database
        $this->json('post', '/api/order', $order->toArray())
        ->assertStatus(200)
        ->assertJsonStructure([
            'user_id', 'customer_id', 'id', 'updated_at', 'created_at'
            ]);

        
    }

    /** @test */
    public function an_authenticated_user_may_add_order_item()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //and a existing order
        $order = factory(\App\Order::class)->create();
        //when the user adds order items to the order
        $order_item = factory(\App\OrderItem::class)->make(
            [
                'order_id' => $order->id
            ]
            );
        $this->json('post' , '/api/order/' . $order->id . '/items', $order_item->toArray())->assertStatus(200);
        
        $this->assertDatabaseHas('order_items', [
            'order_id'=>$order->id
        ]);
        //the order items should be in the database
    }

    /** @test */
    public function an_authenticated_user_may_get_list_of_order()
    {
        //given an authenticate user
        $this->actingAs($this->user, 'api');

        //when user requests a list of order
        //a collection of orders should be returned in json format

        $this->json('get','api/orders')->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id' , 'user_id' , 'customer_id'
            ]
        ]);
    }

    /** @test */
    public function an_user_may_list_items_of_an_order()
    {
        //given an authenticated usr

        //when user request an order

        //a collection of order items should be returned in json format
    }
}
