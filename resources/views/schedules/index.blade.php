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
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">
                    Create Schedule
                </a>
            @endrole
        </div>

        <table id="drivers-table" class="table mt-3">
            <thead>
            <tr>
                <th>Bus No</th>
                <th>Terminal</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->bus->no }}</td>
                    <td>{{ $schedule->terminal->from  }} to {{ $schedule->terminal->to }}</td>
                    <td>{{ $schedule->departure_time->format('l, F j, Y g:i A') }}</td>
                    <td>{{ $schedule->arrival_time->format('l, F j, Y g:i A') }}</td>
                    <td>{{ $schedule->status }}</td>
                    <td>
                        <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-info btn-sm">View</a>
                        @role('admin')
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="post" action="{{ route('admin.schedules.destroy', $schedule->id) }}" style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endrole
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
