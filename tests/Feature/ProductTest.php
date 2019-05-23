<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        $this->user = factory(\App\User::class)->create();
    }
    
    /** @test */
    public function an_authenticated_user_can_list_products()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //when user send a get request 
        //the product list shall be returned in json format
        $this->json('get', '/api/products')->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' =>[
                    'id' , 'name', 'ref_price_aud'
                ]
                
            ]
        ]);
        //and contain list of product with id, ref_price_aud
    }

    /** @test */
    public function an_authenticated_user_can_view_a_product_info()
    {
        //given an authenticated user
        //and a product in the database
        //when user request a product 
        //the product information should be returned in json
        //and json should contain id, name, ref_price_aud
    }

    /** @test */
    public function an_authenticated_user_can_add_new_product()
    {
        //givn an authenticted user
        //when user send a post request with product information
        //the product information should be in database
        //and product information shall be returned in json format
    }
    
}
