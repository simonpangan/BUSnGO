<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 order-1 order-md-0">
                <h1 class="text-center">Contact Us</h1>
                <div>
                    <p><span class="fw-bold">Phone:</span> <br /> 123-456-7890</p>
                    <p><span class="fw-bold">Email:</span> <br />
                        @php $email = "samle@yahoo.com" @endphp
                        <a href="mailto:{{ $email }}">
                            {{ $email }}
                        </a>
                    </p>
                    <p>
                        <span class="fw-bold">Business Hours:</span>
                        <br />
                        Monday – Friday
                        <br />
                        9AM – 5PM (PST)
                        <br />
                        By appointment only
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <img src="{{ asset('bus.jpg') }}" alt="bus" class="img-fluid"/>
            </div>
        </div>
    </div>
</x-app-layout>
