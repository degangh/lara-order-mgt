<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function(Faker $faker){
    
    $name = $faker->name;
    
    return [
        'name' => $name,
        'name_py' => $name,
        'mobile' => $faker->phoneNumber,
        'id_no' => $faker->randomNumber(18,true),
    ];
});

$factory->define(App\Address::class, function(Faker $faker){

    return [
        'mobile' => $faker->phoneNumber,
        'address' => $faker->address,
        'postcode' => $faker->postcode,
        'customer_id' => function(){
            return factory('App\Customer')->create()->id;
        },
    ];

});

$factory->define(App\Product::class, function(){
    return [
        'name' => $faker->name,
        'ref_price_aud' => mt_rand(100,1000)/100,
    ];
});

$factory->define(App\Order::class, function(Faker $faker){
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },

        'customer_id' => function(){
            return factory('App\Customer')->create()->id;
        },

    ];

});

$factory->define(App\OrderItems::class , function (Faker $faker){
    return [
        'order_id' => factory('App\Order')->create()->id,
        'product_id' => factory('App\Product')->create()->id,
        'unit_price_cny' => mt_rand(30, 300),
        'purchase_price_aud' => mt_rand(7,50),
        'exchange_rate' => 5
    ];
});
