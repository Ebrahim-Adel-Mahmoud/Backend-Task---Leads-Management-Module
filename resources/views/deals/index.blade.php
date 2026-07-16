<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Deals') }}</h2>
            <a href="{{ route('deals.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Add Deal') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="GET" action="{{ route('deals.index') }}" class="mb-6 flex flex-wrap gap-2">
                <x-text-input name="search" type="text" class="block w-full max-w-md" placeholder="Search by product or lead name..." :value="request('search')" />
                <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('deals.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">{{ __('Clear') }}</a>
                @endif
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lead</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product/Service</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($deals as $deal)
                            <tr>
                                <td class="px-4 py-3"><a href="{{ route('leads.show', $deal->lead) }}" class="text-indigo-600 hover:text-indigo-900">{{ $deal->lead->name }}</a></td>
                                <td class="px-4 py-3">{{ $deal->product_service }}</td>
                                <td class="px-4 py-3">{{ number_format((float) $deal->budget, 2) }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$deal->status" /></td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('deals.show', $deal) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('deals.edit', $deal) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('deals.destroy', $deal) }}" method="POST" class="inline" onsubmit="return confirm('Delete this deal and all related actions?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No deals found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $deals->links() }}</div>
        </div>
    </div>
</x-app-layout>
