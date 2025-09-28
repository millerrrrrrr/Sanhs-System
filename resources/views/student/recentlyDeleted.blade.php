@extends('layout')
@section('title', 'Deleted Student List')
@section('pagetitle', 'Deleted Student List')

@section('main')

    <div class="h-auto p-4 bg-gray-100">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-[#660B05] mb-4">Deleted Student List</h2>
            <div>
                <table class="min-w-full text-md text-center text-gray-700 shadow-xl">
                    <thead class="bg-[#660B05] text-white">
                        <tr>
                            <th class="py-3 px-4">Name</th>
                            {{-- <th class="py-3 px-4">Age</th> --}}
                            {{-- <th class="py-3 px-4">Gender</th> --}}
                            {{-- <th class="py-3 px-4">Address</th> --}}
                            {{-- <th class="py-3 px-4">Lrn</th> --}}
                            <th class="py-3 px-4">Level</th>
                            <th class="py-3 px-4">Qr Code</th>
                            <th class="py-3 px-4">Deleted at</th>
                            <th class="py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                            <tr class="bg-white hover:bg-gray-300 transition-colors duration-300">
                                <td class="py-3 px-4"> {{ $s->name }} </td>
                                {{-- <td class="py-3 px-4">{{ $s->age }}</td> --}}
                                {{-- <td class="py-3 px-4"></td> --}}
                                {{-- <td class="py-3 px-4">{{ $s->address }}</td> --}}
                                {{-- <td class="py-3 px-4">{{ $s->lrn }}</td> --}}
                                <td class="py-3 px-4"> {{ $s->level }} </td>
                                <td class="py-3 px-4">
                                    <img src=" {{ asset($s->qrCode) }} " alt="QR Code" class="w-16 h-16 mx-auto">
                                </td>
                                <td class="py-3 px-4"> {{ $s->deleted_at }} </td>
                                <td class="py-3 px-4  ">
                                    <div class="inline-block">
                                        <form action=" {{ route('restoreStudent', $s->id) }} " method="POST">
                                            @csrf
                                            <button class="p-1.5 bg-blue-600 rounded-lg cursor-pointer ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.023 9.348h4.992m0 0V4.356m0 4.992-3.181-3.181a9 9 0 1 0 2.678 6.364" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="inline-block">
                                        <form action=" {{ route('permanentlyDelete', $s->id) }} " method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-1.5 bg-red-500 rounded-lg cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="size-6">
                                                    <path fill-rule="evenodd"
                                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center bg-white text-gray-500">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $students->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>

@endsection
