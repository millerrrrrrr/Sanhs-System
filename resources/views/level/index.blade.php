@extends('layout')
@section('title', 'Grade & Secteion')
@section('pagetitle', 'Grade & Section')
@section('main')



    <div class=" h-[20%]">

        <div class="flex justify-center items-center">

            <div class="bg-white p-6 rounded-2xl shadow-md w-md border border-[#e5e7eb]">



                <form action=" {{ route('levelAdd') }} " method="POST">

                    @csrf

                    <div class="mb-4">
                        <label for="category" class="block text-[#3b38a0]  font-medium">Add Grade & Section</label>
                        <input type="category" name="level" class="input"  autofocus>
                           
                        @if ($errors->has('level'))
                            <span class="text-red-500">
                                {{ $errors->first('level') }}
                            </span>
                        @endif
                    </div>



                    <div class="flex items-center justify-between mb-4 text-blue-800">

                        <button type="submit"
                            class="w-full bg-[#3b38a0] hover:bg-[#7a85c1] text-white py-2 rounded-md  transition duration-200 font-medium">
                            Add
                        </button>


                    </div>

                </form>



            </div>

        </div>

    </div>
    <div class="h-[80%]">


        <div class="flex items-center justify-center mt-10">
            <div class="bg-white p-6 rounded-2xl shadow-md w-auto border border-[#e5e7eb]">
                <div class="mt-8 ">
                    <table class="min-w-lg text-sm text-left text-[#111827] border border-[#e5e7eb]">
                        <thead class="bg-[#3b38a0] text-white text-center">
                            <tr>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Edit</th>
                                <th class="px-6 py-3">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($grade as $g)
                                <tr
                                    class="border-b border-[#e5e7eb] hover:bg-[#f1f5f9] transition text-center font-semibold uppercase">
                                    <td class="px-6 py-4 "> {{ $g->level }} </td>
                                    <td class="px-6 py-4 flex gap-x-2 ">
                                        <div class="flex w-full justify-center">
                                            <a href=" {{ Route('levelEdit', $g->id) }} "
                                                class="bg-blue-500 hover:bg-blue-400 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">

                                        <form action="#" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="bg-red-500 hover:bg-red-400 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition">

                                                Delete

                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $grade->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection
