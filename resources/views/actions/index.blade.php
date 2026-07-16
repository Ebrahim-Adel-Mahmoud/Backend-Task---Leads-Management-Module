<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Actions') }}</h2>
            <a href="{{ route('actions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Add Action') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="GET" action="{{ route('actions.index') }}" class="mb-6 flex flex-wrap gap-2">
                <x-text-input name="search" type="text" class="block w-full max-w-md" placeholder="Search by notes, deal, or lead..." :value="request('search')" />
                <select name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">All Types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}" @selected(request('type') === $type->value)>{{ $type->label() }}</option>
                    @endforeach
                </select>
                <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                @if (request()->hasAny(['search', 'type']))
                    <a href="{{ route('actions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">{{ __('Clear') }}</a>
                @endif
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lead</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($actions as $action)
                            <tr>
                                <td class="px-4 py-3"><a href="{{ route('deals.show', $action->deal) }}" class="text-indigo-600 hover:text-indigo-900">{{ $action->deal->product_service }}</a></td>
                                <td class="px-4 py-3">{{ $action->deal->lead->name }}</td>
                                <td class="px-4 py-3"><x-type-badge :type="$action->type" /></td>
                                <td class="px-4 py-3">{{ $action->scheduled_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('actions.show', $action) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('actions.edit', $action) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('actions.destroy', $action) }}" method="POST" class="inline" onsubmit="return confirm('Delete this action?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No actions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $actions->links() }}</div>
        </div>
    </div>
</x-app-layout>
