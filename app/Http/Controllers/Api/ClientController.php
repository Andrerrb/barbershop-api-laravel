<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->clientService->list()
        );
    }

    public function register(StoreClientRequest $request): JsonResponse
    {
        $client = $this->clientService->register($request->validated());

        return response()->json([
            'message' => 'Client registered successfully.',
            'client' => $client,
        ], 201);
    }

    public function show(string $client): JsonResponse
    {
        return response()->json([
            'client' => $this->clientService->find($client),
        ]);
    }

    public function update(
        UpdateClientRequest $request,
        string $client
    ): JsonResponse {
        return response()->json([
            'message' => 'Client updated successfully.',
            'client' => $this->clientService->update(
                $client,
                $request->validated()
            ),
        ]);
    }

    public function destroy(string $client): JsonResponse
    {
        $this->clientService->delete($client);

        return response()->json(null, 204);
    }
}