<?php

use Faker\Generator as Faker;
use App\Models\Image;
use App\Models\Campaign;


$factory->define(Image::class, function (Faker $faker) {

    return [
        "url" => $faker->imageUrl(),
        "name" => "Featured Image",
        "category_id" => rand(1, 2),
        "campaign_id" => Campaign::inRandomOrder()->first()->id 

    ];
});
