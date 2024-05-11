@role('bus admin')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Admin
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="{{ route('admin.drivers.index') }}">{{ __('Drivers') }}</a>
        </li>
        <li> <a class="dropdown-item" href="{{ route('admin.conductors.index') }}">{{ __('Conductors') }}</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.buses.index') }}">{{ __('Buses') }}</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.terminals.index') }}">{{ __('Routes') }}</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.service.index') }}">{{ __('Services') }}</a></li>
    </ul>
</li>
@endrole

