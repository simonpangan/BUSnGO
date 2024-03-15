<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Receipt</title>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center"> Itinerary Details</h2>

    <div class="card rounded p-3" style="max-width: 400px;">
        <div class="mb-3">
            <strong>Reference Number</strong>:
            {{ $payment['reference_number'] }}
        </div>
        <div class="mb-3">
            <strong>Schedule ID</strong>:
            {{ $payment['schedule_id'] }}
        </div>
        <div class="mb-3">
            <strong>Departure Time</strong>:
            {{ $payment['departure_time'] }}
        </div>
        <div class="mb-3">
            <strong>Arrival Time</strong>:
            {{ $payment['arrival_time'] }}
        </div>
        <div class="mb-3">
            <strong>Seats</strong>:
            {{ implode(', ', $payment['tickets_seat_no']) }}
        </div>
        <div class="mb-3">
            <strong>Paid by</strong>: {{ $payment['passenger_name'] }}
        </div>
        <div class="mb-3">
            <strong>Amount</strong>: {{ $payment['amount'] }}
        </div>
        <div class="mb-3">
            <strong>Status</strong>: {{ $payment['status'] }}
        </div>
        <div class="mb-3">
            <strong>Paid At</strong>: {{ $payment['paid_at'] }}
        </div>
        <div style="text-align: center;"><p><span><b>*</b></span> also serves as your official receipt</p></div>
    </div>
</div>
</body>
</html>

