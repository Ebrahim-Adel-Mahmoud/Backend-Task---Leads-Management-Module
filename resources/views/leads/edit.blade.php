<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Lead') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="POST" action="{{ route('leads.update', $lead) }}">
                @csrf
                @method('PUT')
                @include('leads._form', ['lead' => $lead])
                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('leads.show', $lead) }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
