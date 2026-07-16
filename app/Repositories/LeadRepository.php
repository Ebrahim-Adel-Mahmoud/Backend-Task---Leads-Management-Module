<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\LeadDTO;
use App\Models\Lead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class LeadRepository
{
    public function paginate(
        ?string $search = null,
        int $perPage = 15,
        string $sort = 'id',
        string $direction = 'desc',
    ): LengthAwarePaginator {
        $allowedSorts = ['id', 'name', 'phone', 'email', 'created_at'];

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return Lead::query()
            ->withCount('deals')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findOrFail(int $id): Lead
    {
        return Lead::query()
            ->with(['deals' => fn ($query) => $query->with('lead')->latest()])
            ->findOrFail($id);
    }

    public function create(LeadDTO $dto): Lead
    {
        return Lead::query()->create($dto->all());
    }

    public function update(Lead $lead, LeadDTO $dto): Lead
    {
        $lead->update($dto->all());

        return $lead->fresh(['deals']);
    }

    public function delete(Lead $lead): void
    {
        $lead->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Lead>
     */
    public function getAllForSelect(): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::query()
            ->orderBy('name')
            ->get();
    }
}
