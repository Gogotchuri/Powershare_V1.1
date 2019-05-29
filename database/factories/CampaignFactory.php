<?php

use App\Models\References\CampaignStatus;

use Faker\Generator as Faker;
use App\Models\Campaign;
use App\Models\User;
$factory->define(Campaign::class, function (Faker $faker) {

    $campaignStatuses = [CampaignStatus::DRAFT, CampaignStatus::PROPOSAL, CampaignStatus::APPROVED];

    $actions = [
        "Save",
        "Rescue",
        "Collecting money for",
        "Let\"s help",
        "Why doesn\"t anyone care about",
        "Help",
    ];

    $subjects = [
        "poor children",
        "refugees",
        "disabled elderly",
        "army veterans",
        "unemployed youth",
        "clean air",
        "beautiful mountains",
        "clean energy",
    ];

    $locations = [
        "in Georgia",
        "in Armenia",
        "in Turkey",
        "in the Caucasus region",
        "in The Netherlands",
        "in Europe",
        "in Africa",
        "in the United States of America",
        "on the moon",
    ];

    return [
        "name" => array_random($actions) . " " . array_random($subjects) . " " . array_random($locations),
        "details" => implode("\n\n", $faker->paragraphs(rand(2,8))),
        "author_id" => User::inRandomOrder()->first()->id,
        "status_id" => array_random($campaignStatuses),
        "required_funding" => rand(50000, 500000),
        "realized_funding" => rand(100, 50000),
        "category_id" => rand(1,2),
        "video_url" => "https://www.youtube.com/watch?v=RSDqSjTO9fs",
    ];
});
