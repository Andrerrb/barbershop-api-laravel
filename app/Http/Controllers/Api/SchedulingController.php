<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchedulingRequest;
use App\Http\Requests\UpdateSchedulingRequest;
use App\Services\SchedulingService;
use Illuminate\Http\JsonResponse;

class SchedulingController extends Controller
{
    public function __construct(
        private readonly SchedulingService $schedulingService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->schedulingService->list()
        );
    }

    public function agenda(): JsonResponse
    {
    return response()->json(
        $this->schedulingService->agenda()
    );
    }
    
    public function store(
        StoreSchedulingRequest $request
    ): JsonResponse {
        $scheduling = $this->schedulingService->create(
            $request->user(),
            $request->validated()
        );

        return response()->json([
            'message' => 'Scheduling created successfully.',
            'scheduling' => $scheduling,
        ], 201);
    }

    public function show(string $scheduling): JsonResponse
    {
        return response()->json([
            'scheduling' => $this->schedulingService->find($scheduling),
        ]);
    }

    public function update(
        UpdateSchedulingRequest $request,
        string $scheduling
    ): JsonResponse {
        return response()->json([
            'message' => 'Scheduling updated successfully.',
            'scheduling' => $this->schedulingService->update(
                $scheduling,
                $request->validated()
            ),
        ]);
    }

    public function destroy(string $scheduling): JsonResponse
    {
        $this->schedulingService->delete($scheduling);

        return response()->json(null, 204);
    }
}