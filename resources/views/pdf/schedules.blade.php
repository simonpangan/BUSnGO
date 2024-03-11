<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Schedules</title>
</head>
<body>
    <h3 class="text-center">Bus Schedules for today: {{ now()->format('F j, Y'), }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Terminal</th>
                <th scope="col">Departure Time</th>
                <th scope="col">Arrival Time</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $key => $schedule)
                <tr>
                    <th scope="row"> {{ $key + 1 }}</th>
                    <td>
                        {{ $schedule['terminal_from'] }}
                        to
                        {{ $schedule['terminal_to'] }}
                    </td>
                    <td>{{ $schedule['departure_time'] }}</td>
                    <td>{{ $schedule['arrival_time'] }}</td>
                    <td>{{ $schedule['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
