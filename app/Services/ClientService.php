<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function list(): LengthAwarePaginator
    {
        return Client::query()
            ->with('user')
            ->paginate(10);
    }

    public function find(string $id): Client
    {
        return Client::with('user')->findOrFail($id);
    }

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
            ])->load('user');
        });
    }

    public function update(string $id, array $data): Client
    {
        return DB::transaction(function () use ($id, $data) {
            $client = Client::with('user')->findOrFail($id);

            $client->user->update([
                ...array_filter([
                    'name' => $data['name'] ?? null,
                    'email' => $data['email'] ?? null,
                    'password' => $data['password'] ?? null,
                ], fn ($value) => $value !== null),
            ]);

            $client->update([
                ...array_filter([
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                ], fn ($value) => $value !== null),
            ]);

            return $client->fresh('user');
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $client = Client::with('user')->findOrFail($id);

            $client->user->delete();
        });
    }
}