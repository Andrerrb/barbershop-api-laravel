<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminType = UserType::where('name', 'admin')->first();

        if ($adminType) {
            User::firstOrCreate(
                [
                    'email' => 'admin@barbearia.com',
                ],
                [
                    'name' => 'System Administrator',
                    'password' => Hash::make('password123'),
                    'user_type_id' => $adminType->id,
                ]
            );
        }
    }
}