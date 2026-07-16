@props(['deal' => null, 'leads' => [], 'statuses' => [], 'selectedLeadId' => null])

<div class="space-y-4">
    <div>
        <x-input-label for="lead_id" :value="__('Lead')" />
        <select id="lead_id" name="lead_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">Select a lead...</option>
            @foreach ($leads as $lead)
                <option value="{{ $lead->id }}" @selected(old('lead_id', $selectedLeadId ?? $deal?->lead_id) == $lead->id)>
                    {{ $lead->name }} ({{ $lead->phone }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('lead_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="product_service" :value="__('Product / Service')" />
        <x-text-input id="product_service" name="product_service" type="text" class="mt-1 block w-full" :value="old('product_service', $deal?->product_service)" required />
        <x-input-error :messages="$errors->get('product_service')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="budget" :value="__('Budget')" />
        <x-text-input id="budget" name="budget" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('budget', $deal?->budget)" required />
        <x-input-error :messages="$errors->get('budget')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(old('status', $deal?->status?->value ?? 'new') === $status->value)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="notes" :value="__('Notes')" />
        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $deal?->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>
