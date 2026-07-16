@props(['action' => null, 'deals' => [], 'types' => [], 'selectedDealId' => null])

<div class="space-y-4">
    <div>
        <x-input-label for="deal_id" :value="__('Deal')" />
        <select id="deal_id" name="deal_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">Select a deal...</option>
            @foreach ($deals as $deal)
                <option value="{{ $deal->id }}" @selected(old('deal_id', $selectedDealId ?? $action?->deal_id) == $deal->id)>
                    {{ $deal->lead->name }} — {{ $deal->product_service }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('deal_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label :value="__('Type')" />
        <div class="mt-2 space-x-4">
            @foreach ($types as $type)
                <label class="inline-flex items-center">
                    <input type="radio" name="type" value="{{ $type->value }}" @checked(old('type', $action?->type?->value ?? 'call') === $type->value) class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                    <span class="ms-2 text-sm text-gray-600">{{ $type->label() }}</span>
                </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="scheduled_at" :value="__('Date & Time')" />
        <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" :value="old('scheduled_at', $action?->scheduled_at?->format('Y-m-d\TH:i'))" required />
        <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="notes" :value="__('Notes')" />
        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $action?->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>
