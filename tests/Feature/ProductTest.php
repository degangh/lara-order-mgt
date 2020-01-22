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
        $this->product = factory(\App\Product::class)->make();
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
        $this->actingAs($this->user, 'api');
        //when user send a post request with product information
        //product information shall be returned in json format
        $this->json('post', '/api/products', $this->product->toArray())->assertStatus(200)->assertJsonStructure([
            'id', 'name', 'ref_price_aud'
        ]);
        //and the product information should be in database
        $this->assertDatabaseHas('products', [
            'name' => $this->product->name,
            'ref_price_aud' => $this->product->ref_price_aud
        ]);
        
    }

    /** @test */
    public function an_authenticated_user_can_change_product()
    {
        //given an authenticated user
        $this->actingAs($this->user, 'api');
        //and an existing product
        $product = factory(\App\Product::class)->create();

        $new_name = $product->name . ' edit';
        $new_aud = $product->ref_price_aud + 1.5;
        $new_cny = $product->rrp_cny + 3.5;

        $product->name = $new_name;
        $product->ref_price_aud = $new_aud;
        $product->rrp_cny = $new_cny;
    
        //when  user send a patch reuqest with product information
        $this->json('patch', '/api/products/'.$product->id, $product->toArray())->assertStatus(200)->assertJsonStructure([
            'id', 'name', 'ref_price_aud'
        ]);
        //and the product's new information should be in database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $new_name,
            'ref_price_aud' => round($new_aud,2),
            'rrp_cny' => round($new_cny,2)
        ]);
        //product information shall be returned in json format



    }
    
}
