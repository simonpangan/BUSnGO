@role('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('drivers.index') }}">{{ __('Drivers') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('conductors.index') }}">{{ __('Conductors') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('buses.index') }}">{{ __('Buses') }}</a>
    </li>
@endrole
