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
                    <div class="col-4 card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs text-primary text-uppercase mb-1">
                                        Total Earnings:
                                    </div>
                                    <div class="h5 mb-0 text-gray-800">
                                        {{ $totalEarningsThisYear->amount }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <h2>Bookings per month for the current year:</h2>
                <br />
                <canvas id="bookingsChart" width="400" height="200"></canvas>

                <br />
                <h2>Earnings per month for the current year:</h2>
                <br />
                <canvas id="earningsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('bookingsChart').getContext('2d');

                const bookingsPerMonth = @json($bookingsPerMonth);

                const dataByMonth = Array.from({ length: 12 }, () => 0);

                // Fill the dataByMonth array with the booking totals for each month
                bookingsPerMonth.forEach(booking => {
                    const monthIndex = booking.month - 1;
                    dataByMonth[monthIndex] = booking.total;
                });

                const labels = [];

                // Iterate over each month
                for (let month = 1; month <= 12; month++) {
                    // Get the label for the month
                    const label = new Date(2024, month - 1, 1).toLocaleString('default', { month: 'long' });
                    labels.push(label);
                }

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Bookings',
                        data: dataByMonth,
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

                const ctx2 = document.getElementById('earningsChart').getContext('2d');

                const earningsPerMonth = @json($totalEarningsPerMonth);


                const dataByMonthEarnings = Array.from({ length: 12 }, () => 0);

                // Fill the dataByMonth array with the booking totals for each month
                earningsPerMonth.forEach(booking => {
                    const monthIndex = booking.month - 1;
                    dataByMonthEarnings[monthIndex] = booking.amount;
                });

                const labelsEarnings = [];

                // Iterate over each month
                for (let month = 1; month <= 12; month++) {
                    // Get the label for the month
                    const label = new Date(2024, month - 1, 1).toLocaleString('default', { month: 'long' });
                    labelsEarnings.push(label);
                }

                const data2 = {
                    labels: labelsEarnings,
                    datasets: [{
                        label: 'Bookings',
                        data: dataByMonthEarnings,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                };

                new Chart(ctx2, {
                    type: 'bar',
                    data: data2,
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
