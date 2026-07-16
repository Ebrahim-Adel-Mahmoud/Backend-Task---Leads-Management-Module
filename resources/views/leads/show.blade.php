<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $lead->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('leads.edit', $lead) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Edit</a>
                <a href="{{ route('deals.create', ['lead_id' => $lead->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Add Deal</a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><span class="text-sm text-gray-500">Phone</span><p class="font-medium">{{ $lead->phone }}</p></div>
                <div><span class="text-sm text-gray-500">Email</span><p class="font-medium">{{ $lead->email ?? '—' }}</p></div>
                <div class="md:col-span-2"><span class="text-sm text-gray-500">Address</span><p class="font-medium">{{ $lead->address ?? '—' }}</p></div>
                <div class="md:col-span-2"><span class="text-sm text-gray-500">Notes</span><p class="font-medium">{{ $lead->notes ?? '—' }}</p></div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Deals</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product/Service</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($lead->deals as $deal)
                                <tr>
                                    <td class="px-4 py-3">{{ $deal->product_service }}</td>
                                    <td class="px-4 py-3">{{ number_format((float) $deal->budget, 2) }}</td>
                                    <td class="px-4 py-3"><x-status-badge :status="$deal->status" /></td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('deals.show', $deal) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No deals yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
