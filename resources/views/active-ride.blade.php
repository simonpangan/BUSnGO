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
            <h2>My Schedules</h2>
            @role('admin')
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">
                Create Schedule
            </a>
            @endrole
        </div>

        <table id="schedules-table" class="table mt-3">
            <thead>
            <tr>
                <th>Bus No</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->bus->no }}</td>
                        <td>{{ $schedule->departure_time->format('l, F j, Y g:i A') }}</td>
                        <td>{{ $schedule->arrival_time->format('l, F j, Y g:i A') }}</td>
                        <td>{{ $schedule->status }}</td>
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
                $('#schedules-table').DataTable({
                    responsive: true
                })
            });
        </script>
    @endsection
</x-app-layout>