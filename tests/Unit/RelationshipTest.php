<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationshipTest extends TestCase
{
    /** @test */
    public function an_order_has_one_creator()
    {
        $order = factory('App\Order')->create();
        $this->assertInstanceOf('App\User', $order->creator);
    }

    /** @test */
    public function an_order_has_one_customer()
    {
        $order = factory('App\Order')->create();
        $this->assertInstanceOf('App\Customer', $order->customer);
    }

    /** @test */
    public function an_address_has_one_customer()
    {
        $address = factory('App\Address')->create();
        $this->assertInstanceOf('App\Customer', $address->customer);
    }

    /** @test */
    public function an_order_item_has_a_product()
    {
        $order_item = factory('App\OrderItem')->create();
        $this->assertInstanceOf('App\Product', $order_item->product);
    }

    /** @test */
    public function an_item_belong_to_an_order()
    {
        $order_item = factory('App\OrderItem')->create();
        $this->assertInstanceOf('App\Order', $order_item->order);
    }

    /** @test */
    public function an_order_has_items()
    {
        $order = factory('App\Order')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $order->items);
    }

    /** @test */
    public function an_user_creates_many_orders()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->orders);
    }

    /** @test */
    public function a_customer_has_many_orders()
    {
        $customer = factory('App\Customer')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $customer->orders);
    }

    /** @test */
    public function a_customer_has_many_addresses()
    {
        $customer = factory('App\Customer')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $customer->addresses);
    }

    /** @test */
    public function an_address_has_many_orders()
    {
        //give an existing address
        $address = factory('App\Address')->create();
        //and a set of order
        $orders = factory('App\Order', 3)->create(
            [
                "address_id" => $address->id
            ]
        );
        $this->assertInstanceOf('App\Order', $address->orders[0]);
    }

    /** @test */
    public function an_order_has_an_address()
    {
        $order = factory('App\Order')->create();
        $this->assertInstanceOf('App\Address', $order->address);

    }
    
}
