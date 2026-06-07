<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    ) {
    }

    public function register(StoreClientRequest $request): JsonResponse
    {
        $client = $this->clientService->register($request->validated());

        return response()->json([
            'message' => 'Client registered successfully.',
            'client' => $client,
        ], 201);
    }
}