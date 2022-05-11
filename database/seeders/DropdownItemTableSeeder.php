<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DropdownItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dropdown_items')->insert([
            'item' => 'Male',
            'dropdown_id' => 1,
            'status' => 1,
        ]);
        DB::table('dropdown_items')->insert([
            'item' => 'Female',
            'dropdown_id' => 1,
            'status' => 1,
        ]);
        DB::table('dropdown_items')->insert([
            'item' => 'Other / Not Disclosed',
            'dropdown_id' => 1,
            'status' => 1,
        ]);
        DB::table('dropdown_items')->insert([
            'item' => 'Citizen',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		 DB::table('dropdown_items')->insert([
            'item' => 'Permanent Resident',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Convention Refugee',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Refugee Claimant',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'International Student',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Temporary Foreign Worker',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Approved Ontario Provincial Nominee',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Naturalized Canadian',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Visitor',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Canadian Born Citizen',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Applicant for landing',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		DB::table('dropdown_items')->insert([
            'item' => 'Live-in-caregiver on Temporary work Permit',
            'dropdown_id' => 2,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 1',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 2',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 3',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 4',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 5',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 6',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 7',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'CLB 8 and above',
            'dropdown_id' => 3,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Elementary School',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'High School',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'College Diploma',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'College Certificate',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'University: Bachelors',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'University: Masters',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'University: PhD',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Incomplete: High School',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Incomplete: College ',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Incomplete: University Bachelors',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Incomplete: University Masters',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Incomplete: University PhD',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Other: ',
            'dropdown_id' => 4,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Initial: AQIS',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Repeat: AQIS',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Initial: Mobile IRCC',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Repeat: Mobile IRCC',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Initial: Mobile MCIIT',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Repeat: Mobile MCIIT',
            'dropdown_id' => 5,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Attended',
            'dropdown_id' => 6,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'No Show',
            'dropdown_id' => 6,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Client Cancelled',
            'dropdown_id' => 6,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'In-person',
            'dropdown_id' => 7,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Phone',
            'dropdown_id' => 7,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Email',
            'dropdown_id' => 7,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Video Portal',
            'dropdown_id' => 7,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Newmarket Welcome Centre',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Vaughan Welcome Centre',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Richmond Hill Welcome Centre',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Markham North Welcome Centre',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Markham South Welcome Centre',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: Upper York Region',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: Simcoe County',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: Other',
            'dropdown_id' => 8,
            'status' => 1,
			
        ]);
		
			DB::table('dropdown_items')->insert([
            'item' => 'Other',
            'dropdown_id' => 8,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'IRCC',
            'dropdown_id' => 9,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'MCIIT',
            'dropdown_id' => 9,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Social Enterprise for Canada',
            'dropdown_id' => 9,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Portfolio Workshop',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Forum: Engineer',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Forum: Accounting and Finance',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Forum: Supply Chain ',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Workshop: Engineer',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Workshop: Accounting',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Workshop: Nursing',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Accreditation Sector-Specific Workshop: Physicians',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Generic Accreditation Information Sessions',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: Simcoe County Workshop',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: Upper York Region Workshop',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
		
		DB::table('dropdown_items')->insert([
            'item' => 'Mobile Unit: English Conversation Circle',
            'dropdown_id' => 10,
            'status' => 1,
        ]);
    }
}
