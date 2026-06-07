<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserType;

class AdminService
{
    public function create(array $data): User
    {
        $adminType = UserType::where('name', 'admin')->firstOrFail();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type_id' => $adminType->id,
        ]);
    }
}