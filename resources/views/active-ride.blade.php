@php use App\Models\Schedule @endphp

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
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->bus->no }}</td>
                        <td>{{ $schedule->departure_time->format('l, F j, Y g:i A') }}</td>
                        <td>{{ $schedule->arrival_time->format('l, F j, Y g:i A') }}</td>
                        <td>
                            <form
                              action="{{ route('bus-location.update', [
                                    'schedule_id' => $schedule->id,
                                ]) }}"
                              method="POST"
                            >
                                @csrf
                                <select class="form-control status-change @error('status') is-invalid @enderror" aria-label="Status select"
                                    name="status"
                                >
                                    @foreach(Schedule::STATUS as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', $schedule->status) == $status ? "selected" : "" }}
                                        >{{ $status }}</option>
                                    @endforeach
                                    @foreach($schedule->terminal->transit_points as $points)
                                        @php
                                            $fullStatus = "Just passed by ".$points;
                                        @endphp
                                        <option
                                            {{ old('status', $schedule->status) == $fullStatus ? "selected" : "" }}
                                            value="Just passed by {{ $points }}"
                                        >Just passed by {{ $points }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('my-schedule.generate') }}" class="btn btn-danger float-end">
                                <i class="bi bi-file-pdf"></i>
                            </a>
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
                $('#schedules-table').DataTable({
                    responsive: true
                })

                $('.status-change').data('previous-value', $('.status-change').val());
                $('.status-change').on('change', function () {
                    const form = $(this).closest('form')
                    if (confirm('Are you sure you want to change the status?')) {
                        form.submit();
                    } else {
                        $(this).val($(this).data('previous-value'));
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
