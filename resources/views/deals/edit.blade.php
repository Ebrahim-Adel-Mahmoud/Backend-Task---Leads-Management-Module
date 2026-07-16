<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Deal') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="POST" action="{{ route('deals.update', $deal) }}">
                @csrf
                @method('PUT')
                @include('deals._form', ['deal' => $deal, 'leads' => $leads, 'statuses' => $statuses])
                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('deals.show', $deal) }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
