@extends('layout')
@section('title', 'Student List')
@section('pagetitle', 'Student List')

@section('main')

    <div class="h-screen p-4 bg-gray-100">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-[#660B05] mb-4">Student List</h2>
            <div>
                <table class="min-w-full text-md text-center text-gray-700">
                    <thead class="bg-[#660B05] text-white">
                        <tr>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Age</th>
                            <th class="py-3 px-4">Gender</th>
                            <th class="py-3 px-4">Address</th>
                            <th class="py-3 px-4">Lrn</th>
                            <th class="py-3 px-4">Level</th>
                            <th class="py-3 px-4">Qr Code</th>
                            <th class="py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            <tr class="odd:bg-[#f9fafb] even:bg-white hover:bg-[#f2f2f2] transition-colors duration-300">
                                <td class="py-3 px-4">{{ $s->name }}</td>
                                <td class="py-3 px-4">{{ $s->age }}</td>
                                <td class="py-3 px-4">{{ $s->gender }}</td>
                                <td class="py-3 px-4">{{ $s->address }}</td>
                                <td class="py-3 px-4">{{ $s->lrn }}</td>
                                <td class="py-3 px-4">{{ $s->level }}</td>
                                <td class="py-3 px-4">
                                    <img src="{{ asset($s->qrCode) }}" alt="QR Code" class="w-16 h-16 mx-auto">
                                </td>
                                <td class="py-3 px-4">
                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
