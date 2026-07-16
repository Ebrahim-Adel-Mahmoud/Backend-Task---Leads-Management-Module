<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Action') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="POST" action="{{ route('actions.store') }}">
                @csrf
                @include('actions._form', ['deals' => $deals, 'types' => $types, 'selectedDealId' => $selectedDealId])
                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('actions.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
