@extends('layout')
@section('title', 'Grade & Secteion')
@section('pagetitle', 'Grade & Section')
@section('main')



    <div class=" h-[20%]">

        <div class="flex justify-center items-center">

            <div class="bg-white p-6 rounded-2xl shadow-md w-md border border-[#e5e7eb]">



                <form action=" {{ route('levelUpdate', $level->id) }} " method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="category" class="block text-[#3b38a0]  font-medium">Edit Grade & Section</label>
                        <input type="category" name="level" class="input"  autofocus
                         value=" {{ $level->level }} ">
                           
                        @if ($errors->has('level'))
                            <span class="text-red-500">
                                {{ $errors->first('level') }}
                            </span>
                        @endif
                    </div>



                    <div class="flex items-center justify-between mb-4 text-blue-800">

                        <button type="submit"
                            class="btn-edit">
                            Edit
                        </button>


                    </div>

                </form>



            </div>

        </div>

    </div>


@endsection