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

    public function it_can_save_product_info()
    {

    }
}
