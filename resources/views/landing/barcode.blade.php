@extends('layouts.app')

@section('title', 'QR Code Landing')

@section('content')
    <div class="container text-center">
        <h4>QR Code Landing Page</h4>

        <div class="qr-wrapper d-inline-block p-3 bg-white shadow" id="qrArea">
            {{-- Tampilkan QRCode dari link landing --}}
            {!! QrCode::size(200)->generate($landingUrl) !!}
        </div>
        <p class="mt-3">
            atau klik link: <a href="{{ $landingUrl }}" target="_blank">{{ $landingUrl }}</a>
        </p>
        <div class="mt-3">
            <button class="btn btn-primary" id="downloadBtn">Download JPG</button>
        </div>
    </div>

    {{-- html2canvas --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById("downloadBtn").addEventListener("click", function() {
            html2canvas(document.getElementById("qrArea")).then(canvas => {
                let link = document.createElement("a");
                link.download = "qrcode-landing.jpg";
                link.href = canvas.toDataURL("image/jpeg");
                link.click();
            });
        });
    </script>
@endsection
