<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function __construct(
        private readonly AdminService $adminService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->adminService->list()
        );
    }

    public function store(StoreAdminRequest $request): JsonResponse
    {
        $admin = $this->adminService->create($request->validated());

        return response()->json([
            'message' => 'Administrator created successfully.',
            'admin' => $admin,
        ], 201);
    }

    public function show(string $admin): JsonResponse
    {
        return response()->json([
            'admin' => $this->adminService->find($admin),
        ]);
    }

    public function update(
        UpdateAdminRequest $request,
        string $admin
    ): JsonResponse {
        return response()->json([
            'message' => 'Administrator updated successfully.',
            'admin' => $this->adminService->update(
                $admin,
                $request->validated()
            ),
        ]);
    }

    public function destroy(string $admin): JsonResponse
    {
        $this->adminService->delete($admin);

        return response()->json(null, 204);
    }
}