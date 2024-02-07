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
            <h2>Tickets List</h2>
        </div>

        <div>
            <table id="myBuses" style="width: 1000px;" class="display table mt-3">
                <thead>
                <tr>
                    <th>Bus No</th>
                    <th>Seat No</th>
                    <th>Terminal</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->schedule->bus->id }}</td>
                        <td>{{ $ticket->seat_no }}</td>
                        <td>From: {{ $ticket->schedule->terminal->from }}, To: {{ $ticket->schedule->terminal->to }}</td>
                        <td>{{ $ticket->schedule->status }}</td>
                        <td>
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
                $('#myBuses').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
</x-app-layout>
