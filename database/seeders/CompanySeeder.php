<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\{
    User,
    Projects,
    Company
};

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'cyberwrath',
            'contact_person_name' => 'atif',
            'started_date' => date('Y-m-d :h:i:s'),
            'location' => 'Pak',
            'timezone' => 'PK',
            'additional_info' => 'Lorem Ipsum',
            
        ]);
    }
}
