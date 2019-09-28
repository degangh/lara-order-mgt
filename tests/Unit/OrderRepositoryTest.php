<?php

namespace Tests\Unit;
use Mockery;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderRepositoryTest extends TestCase
{
    private $productRepository;
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

    public function it_can_save_order_items()
    {
        //given an existing order 
        $order = $this->orderRepository->create($this->order, $this->user);
        //and a set of order items
        
        //the order items can be saved into database
    }
}
