<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\DealDTO;
use App\Enums\DealStatus;
use App\Models\Deal;
use App\Models\Lead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class DealRepository
{
    public function paginate(
        ?string $search = null,
        ?string $status = null,
        int $perPage = 15,
        string $sort = 'id',
        string $direction = 'desc',
    ): LengthAwarePaginator {
        $allowedSorts = ['id', 'product_service', 'budget', 'status', 'created_at'];

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return Deal::query()
            ->with('lead')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('product_service', 'like', "%{$search}%")
                        ->orWhereHas('lead', function ($leadQuery) use ($search): void {
                            $leadQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findOrFail(int $id): Deal
    {
        return Deal::query()
            ->with(['lead', 'actions' => fn ($query) => $query->latest()])
            ->findOrFail($id);
    }

    public function getAllForSelect(): Collection
    {
        return Deal::query()
            ->with('lead')
            ->latest()
            ->get();
    }

    public function getByLead(Lead $lead): Collection
    {
        return Deal::query()
            ->with('lead')
            ->where('lead_id', $lead->id)
            ->latest()
            ->get();
    }

    public function create(DealDTO $dto): Deal
    {
        return Deal::query()->create($dto->all());
    }

    public function update(Deal $deal, DealDTO $dto): Deal
    {
        $deal->update($dto->all());

        return $deal->fresh(['lead', 'actions']);
    }

    public function delete(Deal $deal): void
    {
        $deal->delete();
    }

    /**
     * @return list<string>
     */
    public function statusOptions(): array
    {
        return array_column(DealStatus::cases(), 'value');
    }
}
