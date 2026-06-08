<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminService
{
    public function list(): LengthAwarePaginator
    {
        return User::query()
            ->whereHas('userType', function ($query) {
                $query->where('name', 'admin');
            })
            ->paginate(10);
    }

    public function find(string $id): User
    {
        return User::query()
            ->whereHas('userType', function ($query) {
                $query->where('name', 'admin');
            })
            ->findOrFail($id);
    }

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

    public function update(string $id, array $data): User
    {
        $admin = $this->find($id);

        $admin->update($data);

        return $admin->fresh();
    }

    public function delete(string $id): void
    {
        $admin = $this->find($id);

        $admin->delete();
    }
}