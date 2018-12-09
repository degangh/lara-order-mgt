<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_may_create_order()
    {
        //given an authenticated user

        //when the user created order

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
