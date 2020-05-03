<?php

namespace Tests\Unit;
use Mockery;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderRepositoryTest extends TestCase
{
    private $productRepository;
    private $orderRepository;
    private $orderItemRepository;
    private $order;
    private $customer;
    private $user;
    private $address;

    public function setUp()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
        $this->customer = factory(\App\Customer::class)->create();
        $this->address = factory(\App\Address::class)->create(['customer_id' => $this->customer->id]);
        $this->order = factory(\App\Order::class)->make([
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id
        ]);
        $this->orderRepository = new \App\Repositories\OrderRepository;
        $this->orderItemRepository = new \App\Repositories\OrderItemRepository;
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_save_order_info()
    {
        //give customer and address
        $order = $this->orderRepository->create($this->order, $this->user);
        //an order instance should be save and returned
        $this->assertInstanceOf('\App\Order', $order);
        //the database should have new created order instance
        $this->assertDatabaseHas('orders', array(
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id
        ));

    }

    /** @test */
    public function it_can_save_order_items()
    {
        //given an existing order 
        $order = $this->orderRepository->create($this->order, $this->user);
        //generate 3 products to add into the order
        $products = factory(\App\Product::class,3)->create();

        //and a set of order items
        $orderItems = $products->map(function ($product ) use (&$order){
            return array(
                "id" => $product->id,
                "rrp_cny" => $product->rrp_cny,
                "ref_price_aud" => $product->ref_price_aud,
                "num" => 1
            );
        });
        $exchange_rate = 5;
        $this->orderRepository->createDetail($order, $orderItems, $exchange_rate);
        //the order items can be saved into database
        $this->assertDatabaseHas('order_items', array(
            'order_id' => $order->id,
            
        ));
    }

    /** @test */
    public function it_can_update_order_change_item()
    {
        //given an existing order
        $order = $this->orderRepository->create($this->order, $this->user);
        $products = factory(\App\Product::class,3)->create();

        //and a set of order items
        $orderItems = $products->map(function ($product ) use (&$order){
            return array(
                "id" => $product->id,
                "rrp_cny" => $product->rrp_cny,
                "ref_price_aud" => $product->ref_price_aud,
                "num" => 1
            );
        });
        $exchange_rate = 4.7;
        $this->orderRepository->createDetail($order, $orderItems, $exchange_rate);
        //an existing order items can be updated
        $item = $order->items[0];
        $new_unit_price = $item->unit_price_cny + 15;
        $new_quantity = $item->quantity + 2;
        $new_purchase_price_aud = $item->purchase_price_aud + 1.5;
        $new_exchange_rate = $item->exchange_rate + 0.2;
        
        $newItem = factory(\App\Product::class)->make(
            [
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'unit_price_cny' => $new_unit_price,
            'purchase_price_aud' => $new_purchase_price_aud ,
            'exchange_rate' => $new_exchange_rate,
            'quantity' => $new_quantity]
            );

        $this->orderItemRepository->update($newItem, $item);

        $this->assertDatabaseHas('order_items', array(
            'order_id' => $order->id,
            'unit_price_cny' => $new_unit_price,
            'purchase_price_aud' => $new_purchase_price_aud,
            'quantity' => $new_quantity
        ));
        
    }

    /** @test */
    public function it_can_update_order_delete_item()
    {
        //give an existing order 
        $order = $this->orderRepository->create($this->order, $this->user);
        //and a set of existing order items
        $orderItems = factory(\App\OrderItem::class,3)->create([
            'order_id' => $order->id
        ]);
        $item = $orderItems[0];
        //one of the order items can be delete from the order
        $this->orderItemRepository->delete($item);

        $this->assertDatabaseMissing('order_items', array(
            'id' => $item->id
        ));
    }

    /** @test */
    public function it_can_update_order_add_item()
    {
        //give an existing order
        $order = $this->orderRepository->create($this->order, $this->user);
        //and a set of existing order items
        $products = factory(\App\Product::class,3)->create();

        //and a set of order items
        $orderItems = $products->map(function ($product ) use (&$order){
            return array(
                "id" => $product->id,
                "rrp_cny" => $product->rrp_cny,
                "ref_price_aud" => $product->ref_price_aud,
                "num" => 1
            );
        });
        //new product
        $new_product = factory(\App\Product::class)->create();
        //an new order item can be added
        $newItem = array(
            "id" => $new_product->id,
            "rrp_cny" => $new_product->rrp_cny,
            "ref_price_aud" => $new_product->ref_price_aud,
            "num" => 1
        );
        
        $this->orderItemRepository->add($order, $newItem, 4.8);
        //the new product can be found 
        $this->assertDatabaseHas('order_items', array(
            'order_id' => $order->id,
            'product_id' => $newItem->product_id
        ));
    }
}
