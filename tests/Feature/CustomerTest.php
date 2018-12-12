<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    /** @test */
    function a_login_user_can_create_customer()
    {
        //given an authenticated user
        //when user create a customer record
        //the new customer record can be returned from server in json format
        //and the new record can be seen in the database
    }

    /** @test */
    function an_unauthenticated_user_cannot_create_customer()
    {
        //given an unauthenticated user
        //when user is trying to create a customer record
        //a 403 error should be returned
    }

    /** @test */
    function an_authenticated_user_can_get_customer_list()
    {
        //given an authenticated user
        //when user request customer list
        //an collection of customer should be returned
    }

}
