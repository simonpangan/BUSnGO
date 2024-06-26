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

        <a title="Download Schedule Today"
            href="{{ route('schedules.generate') }}" class="btn btn-danger float-end">
            <i class="bi bi-file-pdf"></i>
        </a>

        <div class="d-flex justify-content-between align-items-center">
            <h2>Schedules List</h2>
            @role('bus admin')
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">
                    Create A New Schedule
                    <i class="bi bi-plus"></i>
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
                            <a title="Edit Schedule"
                                href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <form method="post" action="{{ route('admin.schedules.destroy', $schedule->id) }}" style="display:inline">
                                @csrf
                                @method('delete')

                                @php
                                    $hasBookings = $schedule->tickets
                                        ->where('status', 'booked')
                                        ->count()
                                        > 0
                                    ;
                                @endphp
                                <button type="submit"
                                        title="Delete Schedule"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('{{ ($hasBookings) ?
                                            'Schedule contains bookings. Are you sure, and proceed to refunds?' :
                                            'Are you sure?'
                                        }}')"
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </button>
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
                    responsive: true,
                    "order": []
                })
            });
        </script>
    @endsection
</x-app-layout>
