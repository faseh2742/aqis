<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GroupActivity;
use App\Staff;
use Faker\Generator as Faker;

public function getFacilitators() {
    $facilitators = Staff::where('position', 'AQIS Facilitator')->get();
    $ids = [];
    foreach ($facilitators as $facilitator) {
        $ids[] = $facilitator->id;
    }

    return $ids;
}

function getDropdown($dropdownName)
{
    $dropDownItems = DropdownItem::with(['dropdown' => function($query) use ($dropdownName) {
        $query->where('name', $dropdownName);
    }])->get();

    return $dropDownItems;
}

$factory->define(GroupActivity::class, function (Faker $faker) {
    return [
        'staff_id' => $faker->randomElement(getFacilitators()->id),
        'programName' => $faker->randomElement(getDropdown('Program Name')),
        'type' => $faker->randomElement(getDropdown('Group Activity Type')),
        'description' => $faker->randomElement(getDropdown('Group Activity Description')),
        'location' => $faker->randomElement(getDropdown('Location')),
        'funder' => $faker->randomElement(getDropdown('Funder')),
    ];
});
