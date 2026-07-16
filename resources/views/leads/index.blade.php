<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Leads') }}</h2>
            <a href="{{ route('leads.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Add Lead') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="GET" action="{{ route('leads.index') }}" class="mb-6 flex gap-2">
                <x-text-input name="search" type="text" class="block w-full max-w-md" placeholder="Search by name, phone, or email..." :value="request('search')" />
                <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                @if (request('search'))
                    <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">{{ __('Clear') }}</a>
                @endif
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deals</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($leads as $lead)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $lead->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $lead->phone }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $lead->email ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $lead->deals_count }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-right space-x-2">
                                    <a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('leads.edit', $lead) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Delete this lead and all related deals/actions?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No leads found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $leads->links() }}</div>
        </div>
    </div>
</x-app-layout>
