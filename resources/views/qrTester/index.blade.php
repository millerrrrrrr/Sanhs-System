@extends('layout')
@section('title', 'Qr Tester')
@section('pagetitle', 'Qr Tester')
@section('main')

<div class="flex flex-col items-center justify-center h-[80%]">
    <h1 class="text-2xl font-bold mb-6">QR Code Scanner</h1>

    <!-- The scanner will be rendered inside this div with max height to prevent overflow -->
    <div id="qr-reader" class="mb-4 w-[500px] max-h-[80vh]"></div>

    <!-- Scanned QR code result will show here -->
    <div id="qr-result" class="hidden mt-4 text-left"> <!-- Change text-center to text-left here -->
        <p class="text-lg">Scanned LRN: <span id="scanned-data" class="font-semibold"></span></p>
    </div>

    <!-- User info will be displayed here below the scanner -->
    <div id="user-info" class="mt-4 text-left"> <!-- Change text-center to text-left here -->
        <!-- User info will be dynamically populated here after scanning -->
    </div>
</div>

@endsection


