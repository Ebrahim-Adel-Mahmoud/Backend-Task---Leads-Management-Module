<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\LeadActionDTO;
use App\Enums\ActionType;
use App\Models\Deal;
use App\Models\LeadAction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class LeadActionRepository
{
    public function paginate(
        ?string $search = null,
        ?string $type = null,
        int $perPage = 15,
        string $sort = 'id',
        string $direction = 'desc',
    ): LengthAwarePaginator {
        $allowedSorts = ['id', 'type', 'scheduled_at', 'created_at'];

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return LeadAction::query()
            ->with('deal.lead')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('notes', 'like', "%{$search}%")
                        ->orWhereHas('deal', function ($dealQuery) use ($search): void {
                            $dealQuery->where('product_service', 'like', "%{$search}%")
                                ->orWhereHas('lead', function ($leadQuery) use ($search): void {
                                    $leadQuery->where('name', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->when($type, function ($query) use ($type): void {
                $query->where('type', $type);
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findOrFail(int $id): LeadAction
    {
        return LeadAction::query()
            ->with('deal.lead')
            ->findOrFail($id);
    }

    public function getByDeal(Deal $deal): Collection
    {
        return LeadAction::query()
            ->with('deal.lead')
            ->where('deal_id', $deal->id)
            ->latest('scheduled_at')
            ->get();
    }

    public function create(LeadActionDTO $dto): LeadAction
    {
        return LeadAction::query()->create($dto->all());
    }

    public function update(LeadAction $action, LeadActionDTO $dto): LeadAction
    {
        $action->update($dto->all());

        return $action->fresh(['deal.lead']);
    }

    public function delete(LeadAction $action): void
    {
        $action->delete();
    }

    /**
     * @return list<string>
     */
    public function typeOptions(): array
    {
        return array_column(ActionType::cases(), 'value');
    }
}
