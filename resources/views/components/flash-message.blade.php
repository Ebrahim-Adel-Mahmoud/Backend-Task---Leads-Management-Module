@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        <x-alert :type="$type" :message="session($type)" />
    @endif
@endforeach
