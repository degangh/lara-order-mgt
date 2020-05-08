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
        $this->orderRepository = new \App\Repositories\OrderRepository;
        $this->orderItemRepository = new \App\Repositories\OrderItemRepository;

        $this->user = factory(\App\User::class)->create();
        $this->customer = factory(\App\Customer::class)->create();
        $this->address = factory(\App\Address::class)->create([
            'customer_id' => $this->customer->id
        ]);
        
    }
    
    /** @test */
    public function an_authenticated_user_may_create_order()
    {
        $order_date = date("Y-m-d");
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        
        //when the user created order
        $order = factory(\App\Order::class)->make([
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_date' => $order_date
            ]
        );

        //the order should be visible in the database
        $response = $this->json('post', '/api/order', $order->toArray())
        ->assertStatus(200)
        ->assertJsonStructure([
            'user_id', 'customer_id', 'id', 'order_date','updated_at', 'created_at'
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
        $this->json('post' , '/api/order/' . $order->id . '/items', $order_item->toArray())->assertStatus(201);
        
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
            'data' =>[
                '*' => [
                'id' , 'user_id' , 'customer_id'
                ]
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

    /** @test */
    public function it_cannot_add_product_when_order_is_paid()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with order detail items
        $orderItems = factory(\App\OrderItem::class)->create([
            'order_id' => $order->id
        ]);
        //when the order is paid
        $this->orderRepository->paid($order);
        //the new order item cannot be added
        $newItem = factory(\App\OrderItem::class)->make([
            'order_id' => $order->id
        ]);

        $this->json('post' , '/api/order/' . $order->id . '/items', $newItem->toArray())
        ->assertStatus(403)
        ->assertJson([
            'message' => 'Order Can NOT be changed after sent or paid'
        ]);
    }

    /** @test */
    public function it_can_change_order_status()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with order detail items
        $orderItems = factory(\App\OrderItem::class)->create([
            'order_id' => $order->id
        ]);

        //the order status can be changed
        $this->json('patch' , '/api/order/' . $order->id . '/paid')
        ->assertSuccessful();

        $this->json('patch' , '/api/order/' . $order->id . '/sent')
        ->assertSuccessful();
    }

    /** @test */
    public function it_cannot_add_product_when_order_is_sent()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with order detail items
        $orderItems = factory(\App\OrderItem::class)->create([
            'order_id' => $order->id
        ]);
        //when the order is paid
        $this->orderRepository->sent($order);
        //the new order item cannot be added
        $newItem = factory(\App\OrderItem::class)->make([
            'order_id' => $order->id
        ]);

        $this->json('post' , '/api/order/' . $order->id . '/items', $newItem->toArray())
        ->assertStatus(403)
        ->assertJson([
            'message' => 'Order Can NOT be changed after sent or paid'
        ]);
    }
    
    /** @test */
    public function it_cannot_change_status_empty_order()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with no order detail items
        
        //set the order is paid
        
        $this->json('patch' , '/api/order/' . $order->id . '/paid')
        ->assertStatus(403)->assertJson([
            'message' => 'There should be as least ONE item in the order'
        ]);

        $this->json('patch' , '/api/order/' . $order->id . '/sent')
        ->assertStatus(403)->assertJson([
            'message' => 'There should be as least ONE item in the order'
        ]);
        
    }

    /** @test */
    public function it_can_delete_order_item()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with order detail items
        $orderItems = factory(\App\OrderItem::class)->create([
            'order_id' => $order->id
        ]);

        //the item of order can be removed
        $this->json('delete' , '/api/orderItems/' . $orderItems->id)
        ->assertSuccessful();
    }

    /** @test */
    public function it_cannot_delete_item_when_status_is_sent()
    {
        //give an authenticated user
        $this->actingAs($this->user, 'api');
        
        //given an exsiting new order
        $order = factory(\App\Order::class)->create();
        
        ///with order detail items
        $orderItems = factory(\App\OrderItem::class)->create([
            'order_id' => $order->id
        ]);

        //when the order is paid
        $this->orderRepository->sent($order);

        $this->json('delete' , '/api/orderItems/' . $orderItems->id)
        ->assertStatus(403)
        ->assertJson([
            'message' => 'Order Can NOT be changed after sent or paid'
        ]);
    }


}
