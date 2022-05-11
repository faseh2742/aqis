<?php

use App\DropdownItem;
use Faker\Generator as Faker;

function getDropdown($dropdownName)
{
    $dropDownItems = DropdownItem::with(['dropdown' => function($query) use ($dropdownName) {
        $query->where('name', $dropdownName);
    }])->get();

    return $dropDownItems;
}

function getLanguage()
{
    $languages = App\Language::all();

    return $languages;
}

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'wc_id' => $faker->unique()->randomNumber(),
//        'immigrationStatus' => $faker->randomElement(getDropdown('Immigration Status')),
        'immigrationStatus' => $faker->randomElement(['Citizen', 'Refugee', 'Permanent Resident']),
        'dob' => $faker->dateTimeBetween('1970-01-01', '2000-12-31'),
        'doa' => $faker->dateTimeBetween('2016-01-01', '2019-12-01'),
        'gender' => $faker->randomElement(['Male', 'Female']),
        'streetAddress' => $faker->streetAddress,
        'city' => $faker->city,
        'province' => $faker->state,
        'postalCode' => $faker->postcode,
        'phonePrimary' => $faker->phoneNumber,
        'phoneSecondary' => $faker->phoneNumber,
        'motherTongue' => $faker->randomElement(getLanguage()),
        'countryOrigin' => $faker->country,
        'engProficiency' => $faker->randomElement(['Level 1', 'Level 2', 'Level 3']),
        'interpreterNeeded' => '0',
        'interpreterLanguage' => '',
        'childcareNeeded' => $faker->randomElement([0,1]),
        'notes' => $faker->realText(100),
    ];
});
