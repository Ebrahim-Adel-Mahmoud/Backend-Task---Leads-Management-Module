<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\DealDTO;
use App\Enums\DealStatus;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Repositories\DealRepository;
use App\Repositories\LeadRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DealController extends Controller
{
    public function __construct(
        private readonly DealRepository $repository,
        private readonly LeadRepository $leadRepository,
    ) {}

    public function index(Request $request): View
    {
        return view('deals.index', [
            'deals' => $this->repository->paginate(
                search: $request->query('search'),
                status: $request->query('status'),
                perPage: (int) $request->query('per_page', 15),
                sort: $request->query('sort', 'id'),
                direction: $request->query('direction', 'desc'),
            ),
            'statuses' => DealStatus::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('deals.create', [
            'leads' => $this->leadRepository->getAllForSelect(),
            'statuses' => DealStatus::cases(),
            'selectedLeadId' => $request->query('lead_id'),
        ]);
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $deal = $this->repository->create(DealDTO::fromRequest($request));

        return redirect()
            ->route('deals.show', $deal)
            ->with('success', 'Deal created successfully.');
    }

    public function show(int $deal): View
    {
        return view('deals.show', [
            'deal' => $this->repository->findOrFail($deal),
        ]);
    }

    public function edit(int $deal): View
    {
        return view('deals.edit', [
            'deal' => $this->repository->findOrFail($deal),
            'leads' => $this->leadRepository->getAllForSelect(),
            'statuses' => DealStatus::cases(),
        ]);
    }

    public function update(UpdateDealRequest $request, int $deal): RedirectResponse
    {
        $dealModel = $this->repository->findOrFail($deal);
        $this->repository->update($dealModel, DealDTO::fromRequest($request));

        return redirect()
            ->route('deals.show', $dealModel)
            ->with('success', 'Deal updated successfully.');
    }

    public function destroy(int $deal): RedirectResponse
    {
        $dealModel = $this->repository->findOrFail($deal);
        $this->repository->delete($dealModel);

        return redirect()
            ->route('deals.index')
            ->with('success', 'Deal deleted successfully.');
    }
}
