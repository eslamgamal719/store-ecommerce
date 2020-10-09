<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'ar' => ['name'   => $faker->text(60),'description'     => $faker->text(80)],
        'en' => ['name'   => $faker->text(60),'description'     => $faker->text(80)],
        'price'           =>$faker->numberBetween(10, 9000),
        'manage_stock'    => false,
        'in_stock'        => $faker->boolean(),
        'slug'            =>$faker->slug(),
        'sku'             =>$faker->word(),
        'is_active'       =>$faker->boolean(),
    ];
});
