<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $action->type->label() }} — {{ $action->scheduled_at->format('Y-m-d H:i') }}</h2>
            <a href="{{ route('actions.edit', $action) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Edit</a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><span class="text-sm text-gray-500">Type</span><p class="font-medium"><x-type-badge :type="$action->type" /></p></div>
            <div><span class="text-sm text-gray-500">Date & Time</span><p class="font-medium">{{ $action->scheduled_at->format('Y-m-d H:i') }}</p></div>
            <div><span class="text-sm text-gray-500">Deal</span><p class="font-medium"><a href="{{ route('deals.show', $action->deal) }}" class="text-indigo-600 hover:text-indigo-900">{{ $action->deal->product_service }}</a></p></div>
            <div><span class="text-sm text-gray-500">Lead</span><p class="font-medium"><a href="{{ route('leads.show', $action->deal->lead) }}" class="text-indigo-600 hover:text-indigo-900">{{ $action->deal->lead->name }}</a></p></div>
            <div class="md:col-span-2"><span class="text-sm text-gray-500">Notes</span><p class="font-medium">{{ $action->notes ?? '—' }}</p></div>
        </div>
    </div>
</x-app-layout>
