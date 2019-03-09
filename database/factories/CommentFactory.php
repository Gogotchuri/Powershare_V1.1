<?php

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        "author_id" => User::inRandomOrder()->first()->id,
        "body" => $faker->sentences(2, true),
        "campaign_id" => Campaign::inRandomOrder()->first()->id,
        "is_public" => rand(0,1),
    ];
});
