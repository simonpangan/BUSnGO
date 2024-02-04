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
            <h2>Schedules List</h2>
            @role('admin')
                <a href="{{ route('admin.terminals.create') }}" class="btn btn-success">
                    Create Terminal
                </a>
            @endrole
        </div>

        <table id="drivers-table" class="table mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($terminals as $terminal)
                <tr>
                    <td>{{ $terminal->id }}</td>
                    <td>{{ $terminal->from }}</td>
                    <td>{{ $terminal->to }}</td>
                    <td>
                            <a href="{{ route('admin.terminals.edit', $terminal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="post" action="{{ route('admin.terminals.destroy', $terminal->id) }}" style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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
                    responsive: true
                })
            });
        </script>
    @endsection
</x-app-layout>
