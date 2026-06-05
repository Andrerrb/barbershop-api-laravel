<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'admin'],
            ['name' => 'client'],
        ];

        foreach ($userTypes as $type) {
            UserType::firstOrCreate($type);
        }
    }
}