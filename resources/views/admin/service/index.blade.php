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

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2>Service List</h2>
            <a href="{{ route('admin.service.create') }}" class="btn btn-success">
                Create Service
                <i class="bi bi-plus"></i>
            </a>
        </div>

        <div>
            <table id="myService" style="width: 1000px;" class="display table mt-3">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>BUS NO</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Duration</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->bus->no }}</td>
                        <td>{{ $service->description }}</td>
                        <td>{{ $service->status }}</td>
                        <td>{{ $service->duration }}</td>
                        <td>
                            <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <form method="post" action="{{ route('admin.service.destroy', $service->id) }}" style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash-fill"></i>
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
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#myService').DataTable({
                    responsive: true,
                    "order": []
                })
            });
        </script>
    @endsection
</x-app-layout>
