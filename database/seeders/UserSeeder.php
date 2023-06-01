<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\{
    Projects,
    Company
};
use App\Models\User;

class UserSeeder extends Seeder
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
            'email' => 'atif',
            'role' => 'developer',
            'status' => 'active'
        ]);
    }
}
