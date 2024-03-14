<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('passenger.tickets')  }}" class="btn btn-primary">Back to list</a>

        <h2 class="text-center">Itenary Details</h2>

        <div class="row justify-content-center">
                <div class="card rounded p-3" style="max-width: 400px;">
                <div class="mb-3">
                    <strong>Reference Number</strong>:
                    {{ $payment->id }}
                </div>
                <div class="mb-3">
                    <strong>Schedule ID</strong>:
                    {{ $payment->schedule_id }}
                </div>
                <div class="mb-3">
                    <strong>Seats</strong>:
                    {{ implode(', ', $payment->tickets->pluck('seat_no')->toArray()) }}
                </div>
                <div class="mb-3">
                    <strong>Paid by</strong>: {{ $payment->passenger->name }}
                </div>
                <div class="mb-3">
                    <strong>Amount</strong>: {{ $payment->amount }}
                </div>
                <div class="mb-3">
                    <strong>Status</strong>: {{ $payment->status }}
                </div>
                <div class="mb-3">
                    <strong>Paid At</strong>: {{ $payment->paid_at->format('l, F j, Y g:i A') }}
                </div>
            </div>
</x-app-layout>
