<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Receipts</title>
</head>
<body>
<h1 class="text-center">Schedule Ticket <Reference></Reference></h1>
<strong>Schedule ID:</strong>{{ $schedule_id }}
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Reference Number</th>
            <th scope="col">Seats</th>
            <th scope="col">Paid By</th>
            <th scope="col">Amount</th>
            <th scope="col">Paid At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $key => $payment)
            <tr>
                <th scope="row"> {{ $key + 1 }}</th>
                <td>{{ $payment['reference_number'] }}</td>
                <td>{{ implode(', ', $payment['tickets_seat_no']) }}</td>
                <td>{{ $payment['paid_by'] }}</td>
                <td>{{ $payment['amount'] }}</td>
                <td>{{ $payment['paid_at'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
