@extends('layout')
@section('title', 'Qr Tester')
@section('pagetitle', 'Qr Tester')
@section('main')

    <div class="flex flex-col items-center justify-center h-[80%]">
        <h1 class="text-2xl font-bold mb-6">QR Code Scanner</h1>

        <div id="qr-reader" class="mb-4 w-[500px] max-h-[80vh]"></div>

        <div id="qr-result" class="hidden mt-4 text-left">
            <p class="text-lg">Scanned LRN: <span id="scanned-data" class="font-semibold"></span></p>
        </div>
        >
        <div id="user-info" class="mt-4 text-left">
        </div>
    </div>

@endsection
