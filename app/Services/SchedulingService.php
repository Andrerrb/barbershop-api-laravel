<?php

namespace App\Services;

use App\Models\Scheduling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class SchedulingService
{
    public function list(): LengthAwarePaginator
    {
        return Scheduling::query()
            ->with('client.user')
            ->orderBy('start_date')
            ->paginate(10);
    }

    public function find(string $id): Scheduling
    {
        return Scheduling::with('client.user')->findOrFail($id);
    }

    public function create(User $user, array $data): Scheduling
    {
        $client = $user->client()->firstOrFail();

        $this->ensureValidPeriod(
            $data['start_date'],
            $data['end_date']
        );

        $this->ensureNoConflict(
            $data['start_date'],
            $data['end_date']
        );

        return Scheduling::create([
            'client_id' => $client->id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ])->load('client.user');
    }

    public function update(string $id, array $data): Scheduling
    {
        $scheduling = Scheduling::findOrFail($id);

        $startDate = $data['start_date'] ?? $scheduling->start_date;
        $endDate = $data['end_date'] ?? $scheduling->end_date;

        $this->ensureValidPeriod($startDate, $endDate);

        $this->ensureNoConflict(
            $startDate,
            $endDate,
            $scheduling->id
        );

        $scheduling->update([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return $scheduling->fresh('client.user');
    }

    public function delete(string $id): void
    {
        $scheduling = Scheduling::findOrFail($id);

        $scheduling->delete();
    }

    private function ensureValidPeriod(
        mixed $startDate,
        mixed $endDate
    ): void {
        if (Carbon::parse($endDate)->lte(Carbon::parse($startDate))) {
            throw ValidationException::withMessages([
                'end_date' => [
                    'The end date must be after the start date.',
                ],
            ]);
        }
    }

    private function ensureNoConflict(
        mixed $startDate,
        mixed $endDate,
        ?string $ignoreId = null
    ): void {
        $hasConflict = Scheduling::query()
            ->when(
                $ignoreId,
                fn ($query) => $query->where('id', '!=', $ignoreId)
            )
            ->where('start_date', '<', $endDate)
            ->where('end_date', '>', $startDate)
            ->exists();

        if ($hasConflict) {
            throw ValidationException::withMessages([
                'start_date' => [
                    'The selected time conflicts with an existing scheduling.',
                ],
            ]);
        }
    }
}