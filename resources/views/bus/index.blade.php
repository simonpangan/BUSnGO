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
            <h2>Buses List</h2>
            <a href="{{ route('buses.create') }}" class="btn btn-success">Create Bus</a>
        </div>

        <div>
            <table id="myBuses" style="width: 1000px;" class="display table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No</th>
                    <th>Seat</th>
                    <th>Engine Model</th>
                    <th>Chassis No</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Register No</th>
                    <th>Made In</th>
                    <th>Make</th>
                    <th>Price</th>
                    <th>Fuel</th>
                    <th>Engine Capacity</th>
                    <th>Purchase Year</th>
                    <th>Transmission Model</th>
                    <th>Status</th>
                    <th>Driver Name</th>
                    <th>Conductor Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($buses as $bus)
                <tr>
                    <td>{{ $bus->id }}</td>
                    <td>{{ $bus->no }}</td>
                    <td>{{ $bus->seat }}</td>
                    <td>{{ $bus->engine_model }}</td>
                    <td>{{ $bus->chassis_no }}</td>
                    <td>{{ $bus->model }}</td>
                    <td>{{ $bus->color }}</td>
                    <td>{{ $bus->register_no }}</td>
                    <td>{{ $bus->made_in }}</td>
                    <td>{{ $bus->make }}</td>
                    <td>{{ $bus->price }}</td>
                    <td>{{ $bus->fuel }}</td>
                    <td>{{ $bus->engine_capacity }}</td>
                    <td>{{ $bus->puchase_year }}</td>
                    <td>{{ $bus->transmission_model }}</td>
                    <td>{{ $bus->status }}</td>
                    <td>{{ $bus->driver->name }}</td>
                    <td>{{ $bus->conductor->name }}</td>
                    <td>{{ $bus->created_at }}</td>
                    <td>{{ $bus->updated_at }}</td>
                    <td>
                        <a href="{{ route('buses.show', $bus->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('buses.edit', $bus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="post" action="{{ route('buses.destroy', $bus->id) }}" style="display:inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>

    @section('javascript')
        @jquery
         <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#myBuses').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
</x-app-layout>
