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

        $this->productRepository = Mockery::mock('ProdcutRepositoryInterface');
        $this->app->instance('ProductRepositoryInterface', $this->productRespository);
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

        //data base has the new created product information

    }
}
