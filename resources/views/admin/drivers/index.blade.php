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
            <h2>Driver List</h2>
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-success">
                Create New Driver Information
                <i class="bi bi-plus"></i>
            </a>
        </div>
        <table id="drivers-table" class="table mt-4">
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
            @foreach($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->gender }}</td>
                    <td>{{ $driver->address }}</td>
                    <td>{{ $driver->city }}</td>
                    <td>{{ $driver->contact_no }}</td>
                    <td>
                        <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info btn-sm">View</a>
                        <a title="Edit Driver"
                            href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <form method="post" action="{{ route('admin.drivers.destroy', $driver->id) }}" style="display:inline">
                            @csrf
                            @method('delete')
                            @php
                                $count =  $driver
                                    ->schedules()
                                    ->where('status', "!=", 'Arrived')
                                    ->count();
                            @endphp
                            <button
                                title="Delete Driver"
                                type="submit" class="btn btn-danger btn-sm" onclick="
                                    @if($count >= 1)
                                            alert('Cannot delete a conductor that is currently assigned. Please change the assignment first.')
                                            return false;
                                    @else
                                        return confirm('Are you sure?')
                                    @endif
                                ">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @section('javascript')
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#drivers-table').DataTable({
                    responsive: true,
                    "order": []
                })
            });
        </script>
    @endsection
</x-app-layout>
