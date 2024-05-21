@php
    use Illuminate\Support\Carbon;
@endphp
<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-4 card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs text-primary text-uppercase mb-1">
                                        Total bookings this month:
                                    </div>
                                    <div class="h5 mb-0 text-gray-800">
                                        {{ $bookingsThisMonth }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs text-primary text-uppercase mb-1">
                                        Total bookings this year:
                                    </div>
                                    <div class="h5 mb-0 text-gray-800">
                                        {{ $bookingsThisMonth }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p>Bookings per month for the current year:</p>
                <ul>
                    @foreach($bookingsPerMonth as $booking)
                        <li>Month {{  Carbon::create()->month($booking->month)->monthName }}: {{ $booking->total }}</li>
                    @endforeach
                </ul>

                <br />
                <br />
                <br />
                <canvas id="bookingsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    @php
        $temp = [
            ['month' => 1, 'total' => 10],
            ['month' => 2, 'total' => 15],
            ['month' => 3, 'total' => 25],
        ];
    @endphp

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('bookingsChart').getContext('2d');

                const bookingsPerMonth = @json($temp);

                const labels = bookingsPerMonth.map(booking => {
                    const month = booking.month;
                    return new Date(2024, month - 1, 1).toLocaleString('default', { month: 'long' });
                });

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Bookings',
                        data: bookingsPerMonth.map(booking => booking.total),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
