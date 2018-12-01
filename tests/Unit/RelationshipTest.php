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
    
}
