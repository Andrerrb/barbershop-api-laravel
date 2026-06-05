<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'Admin'],
            ['name' => 'Barber'],
            ['name' => 'Customer'],
        ];

        foreach ($userTypes as $type) {
            UserType::firstOrCreate($type);
        }
    }
}
