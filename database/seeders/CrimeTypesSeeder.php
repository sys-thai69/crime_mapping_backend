<?php

// database/seeders/CrimeTypesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrimeTypesSeeder extends Seeder
{
    public function run()
    {
        $crimeTypes = [
            ['crime_type_name' => 'Cyber Fraud'],
            ['crime_type_name' => 'Identity Theft'],
            ['crime_type_name' => 'Vandalism'],
            ['crime_type_name' => 'Shoplifting'],
            ['crime_type_name' => 'Embezzlement'],
            ['crime_type_name' => 'Drug Possession'],
            ['crime_type_name' => 'Drunk Driving'],
            ['crime_type_name' => 'Domestic Violence'],
            ['crime_type_name' => 'Robbery'],
            ['crime_type_name' => 'Art Theft'],
            ['crime_type_name' => 'Other (Specify)'],
        ];

        DB::table('crime_types')->insert($crimeTypes);
    }
}
