<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\LeadActionDTO;
use App\Enums\ActionType;
use App\Http\Requests\StoreLeadActionRequest;
use App\Http\Requests\UpdateLeadActionRequest;
use App\Repositories\DealRepository;
use App\Repositories\LeadActionRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class LeadActionController extends Controller
{
    public function __construct(
        private readonly LeadActionRepository $repository,
        private readonly DealRepository $dealRepository,
    ) {}

    public function index(Request $request): View
    {
        return view('actions.index', [
            'actions' => $this->repository->paginate(
                search: $request->query('search'),
                type: $request->query('type'),
                perPage: (int) $request->query('per_page', 15),
                sort: $request->query('sort', 'id'),
                direction: $request->query('direction', 'desc'),
            ),
            'types' => ActionType::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('actions.create', [
            'deals' => $this->dealRepository->getAllForSelect(),
            'types' => ActionType::cases(),
            'selectedDealId' => $request->query('deal_id'),
        ]);
    }

    public function store(StoreLeadActionRequest $request): RedirectResponse
    {
        $action = $this->repository->create(LeadActionDTO::fromRequest($request));

        return redirect()
            ->route('actions.show', $action)
            ->with('success', 'Action created successfully.');
    }

    public function show(int $action): View
    {
        return view('actions.show', [
            'action' => $this->repository->findOrFail($action),
        ]);
    }

    public function edit(int $action): View
    {
        return view('actions.edit', [
            'action' => $this->repository->findOrFail($action),
            'deals' => $this->dealRepository->getAllForSelect(),
            'types' => ActionType::cases(),
        ]);
    }

    public function update(UpdateLeadActionRequest $request, int $action): RedirectResponse
    {
        $actionModel = $this->repository->findOrFail($action);
        $this->repository->update($actionModel, LeadActionDTO::fromRequest($request));

        return redirect()
            ->route('actions.show', $actionModel)
            ->with('success', 'Action updated successfully.');
    }

    public function destroy(int $action): RedirectResponse
    {
        $actionModel = $this->repository->findOrFail($action);
        $this->repository->delete($actionModel);

        return redirect()
            ->route('actions.index')
            ->with('success', 'Action deleted successfully.');
    }
}
