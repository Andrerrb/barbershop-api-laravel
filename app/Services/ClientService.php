<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function register(array $data): Client
    {
        return DB::transaction(function () use ($data) {
            $clientType = UserType::where('name', 'client')->firstOrFail();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'user_type_id' => $clientType->id,
            ]);

            return Client::create([
                'user_id' => $user->id,
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
            ]);
        });
    }
}