<?php

namespace Tests\Unit;

use Mockery;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRespositoryTest extends TestCase
{
    private $productRepository;

    public function setUp()
    {
        parent::setup();

        /*
        $this->productRepository = Mockery::mock('ProductRepositoryInterface');
        $this->app->instance('ProductRepositoryInterface', $this->productRepository);
        $this->product = factory(\App\Product::class)->make();
        $this->productRepository->shouldReceive('create')->andReturn($this->product);
        */
        $this->product = factory(\App\Product::class)->make();
        $this->productRepository = new \App\Repositories\ProductRepository;
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_save_product_info()
    {
        //given a product name and price

        //a product instance should be saved, and returned
        $product = $this->productRepository->create(
            $this->product
        );
        //data base has the new created product information
        $this->assertInstanceOf('\App\Product', $product);

        $this->assertDatabaseHas('products', array(
            'name' => $this->product->name,
            'ref_price_aud' => $this->product->ref_price_aud
        ));
    }
}
