<x-app-layout>
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Drivers List</h2>
            <a href="{{ route('drivers.create') }}" class="btn btn-success">Create Driver</a>
        </div>

        <table class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>City</th>
                <th>Contact Number</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->gender }}</td>
                    <td>{{ $driver->address }}</td>
                    <td>{{ $driver->city }}</td>
                    <td>{{ $driver->contact_no }}</td>
                    <td>{{ $driver->username }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>
                        <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="post" action="{{ route('drivers.destroy', $driver->id) }}" style="display:inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No drivers found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
