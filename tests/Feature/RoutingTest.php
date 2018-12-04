<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutingTest extends TestCase
{
    /** @test */
    function get_order_list()
    {
        $this->json('get', '/api/orders')->assertStatus(200);
    }

    /** @test */
    function get_product_list()
    {
        $this->json('get', '/api/products')->assertStatus(200);
    }
}
