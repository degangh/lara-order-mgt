<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutingTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
    }
    
    
    /** @test */
    function get_order_list()
    {
        
        $this->actingAs($this->user, 'api');
        $this->json('get', '/api/orders')
        ->assertStatus(200);
    }

    /** @test */
    function get_product_list()
    {   
        
        $this->actingAs($this->user, 'api');

        $this->json('get', '/api/products')->assertStatus(200);
    }

    /** @test */
    function user_no_login_get_product_list()
    {
        $this->json('get', '/api/products')->assertStatus(401);
    }

    /** @test */
    function user_no_login_get_order_list()
    {
        $this->json('get', '/api/orders')->assertStatus(401);
    }



}
