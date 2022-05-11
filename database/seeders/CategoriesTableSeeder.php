<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
            'name' => 'Certification / Licensing',
            'value' => 'certificationLicensing'
            ]
        );
        
        DB::table('categories')->insert(
            [
            'name' => 'Credential Assessment',
            'value' => 'credentialAssessment'
            ]
        );


        DB::table('categories')->insert(
            [
            'name' => 'Document Translation',
            'value' => 'documentTranslation'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Training',
            'value' => 'training'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Local Experience',
            'value' => 'localExperience'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Alternative Career',
            'value' => 'alternativeCareer'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Mentoring / Networking',
            'value' => 'mentoringNetworking'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Portfolio Workshop',
            'value' => 'portfolioWorkshop'
            ]
        );

        DB::table('categories')->insert(
            [
            'name' => 'Other Resources',
            'value' => 'otherResources'
            ]
        );
    }
}
