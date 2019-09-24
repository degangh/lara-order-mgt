<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderRepositoryTest extends TestCase
{
    private $productRepository;
    private $order;

    public function setUp()
    {
        parent::setup();

        $this->order = factory(\App\Order::class)->make();
        $this->orderRepository = new \App\Repositories\OrderRepository;
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function it_can_save_order_info()
    {
        //give customer and address

        //an order instance should be save and returned

        //the database should have new created order instance

    }

    public function it_can_save_order_items()
    {
        //given an existing order 

        //and a set of order items

        //the order items can be saved into database
    }
}
