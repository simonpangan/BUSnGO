@role('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.drivers.index') }}">{{ __('Drivers') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.conductors.index') }}">{{ __('Conductors') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.buses.index') }}">{{ __('Buses') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.terminals.index') }}">{{ __('Terminals') }}</a>
    </li>
@endrole
