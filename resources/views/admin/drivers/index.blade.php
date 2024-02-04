<x-app-layout>
    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"/>
    @endsection

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Terminal List</h2>
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-success">Create Driver</a>
        </div>

        <table id="drivers-table" class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>City</th>
                <th>Contact Number</th>
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
                    <td>
                        <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="post" action="{{ route('admin.drivers.destroy', $driver->id) }}" style="display:inline">
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

    @section('javascript')
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#drivers-table').DataTable({
                    responsive: true
                })
            });
        </script>
    @endsection
</x-app-layout>
