@extends('layout')
@section('title', 'Student List')
@section('pagetitle', 'Student List')

@section('main')
    <div>
        <a href=" {{ route('studentList') }} ">
            <button class="btn-delete shadow-lg">
                Back
            </button>
        </a>
    </div>
    <div class="flex items-center justify-center min-h-auto ">
        <div class="bg-white shadow-2xl rounded-2xl w-80 p-6">
            <!-- QR Code -->
            <div class="flex justify-center mb-4">
                <img src=" {{ asset($student->qrCode) }} " alt="QR Code" class="w-24 h-24">
            </div>

            <!-- Info -->
            <div class="space-y-2 text-gray-700">
                <p><span class="font-semibold">Name:</span> {{ $student->name }} </p>
                <p><span class="font-semibold">Age:</span> {{ $student->age }} </p>
                <p><span class="font-semibold">Gender:</span> {{ $student->gender }} </p>
                <p><span class="font-semibold">Address:</span> {{ $student->address }} </p>
                <p><span class="font-semibold">LRN:</span> {{ $student->lrn }} </p>
                <p><span class="font-semibold">Level:</span> {{ $student->level }} </p>
                <p><span class="font-semibold">Guardian:</span> {{ $student->guardian }} </p>
                <p><span class="font-semibold">Guardian's Email:</span> {{ $student->email }} </p>
            </div>
        </div>
    </div>


@endsection
