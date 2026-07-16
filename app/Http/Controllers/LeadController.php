<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\LeadDTO;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\LeadRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class LeadController extends Controller
{
    public function __construct(
        private readonly LeadRepository $repository,
    ) {}

    public function index(Request $request): View
    {
        return view('leads.index', [
            'leads' => $this->repository->paginate(
                search: $request->query('search'),
                perPage: (int) $request->query('per_page', 15),
                sort: $request->query('sort', 'id'),
                direction: $request->query('direction', 'desc'),
            ),
        ]);
    }

    public function create(): View
    {
        return view('leads.create');
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = $this->repository->create(LeadDTO::fromRequest($request));

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Lead created successfully.');
    }

    public function show(int $lead): View
    {
        return view('leads.show', [
            'lead' => $this->repository->findOrFail($lead),
        ]);
    }

    public function edit(int $lead): View
    {
        return view('leads.edit', [
            'lead' => $this->repository->findOrFail($lead),
        ]);
    }

    public function update(UpdateLeadRequest $request, int $lead): RedirectResponse
    {
        $leadModel = $this->repository->findOrFail($lead);
        $this->repository->update($leadModel, LeadDTO::fromRequest($request));

        return redirect()
            ->route('leads.show', $leadModel)
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(int $lead): RedirectResponse
    {
        $leadModel = $this->repository->findOrFail($lead);
        $this->repository->delete($leadModel);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}
