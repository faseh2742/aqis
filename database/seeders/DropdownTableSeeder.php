<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DropdownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dropdowns')->insert(
            [
            'name' => 'Gender',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Immigration Status',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Language Proficiency',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Level of Education',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Meeting Type' ,
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Meeting Status',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Service Delivery Method',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Location',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Funder',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Group Activity Type',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Program Name',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Meeting Service Provided',
            ]
        );
        DB::table('dropdowns')->insert(
            [
            'name' => 'Group Activity Description',
            ]
        );
    }

}
