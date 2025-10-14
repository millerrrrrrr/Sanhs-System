@extends('layout')
@section('title', 'Register Student')
@section('pagetitle', 'Register Student')

@section('main')
    <div class="p-6 bg-white w-full  max-w-2xl mx-auto rounded-md shadow-md h-[80%]">
        <h2 class="text-2xl font-bold mb-6  text-gray-700 text-center">Student Registration</h2>




        <form action="{{ route('registerStudent') }}" method="POST" class="space-y-2.5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600">Full Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    value="{{ old('name') }}">
            </div>

            {{-- Age --}}
            <div>
                <label for="age" class="block text-sm font-medium text-gray-600">Age</label>
                <input type="number" name="age" id="age" min="1" max="100"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    value="{{ old('age') }}">
            </div>

            {{-- Gender --}}
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-600">Gender</label>
                <select name="gender" id="gender"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="" disabled selected>-- Select Gender --</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                <textarea name="address" id="address" rows="2"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"> {{ old('address') }} </textarea>
            </div>

            {{-- LRN --}}
            <div>
                <label for="lrn" class="block text-sm font-medium text-gray-600">LRN (12 digits)</label>
                <input type="number" name="lrn" id="lrn" maxlength="12" pattern="\d{12}"
                    value="{{ old('lrn') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    placeholder="Enter 12-digit LRN" oninput="limitLRNLength(event)">
          
            </div>


            <style>input[type="number"] {
            -webkit-appearance: none; /* Chrome, Safari */
            -moz-appearance: textfield; /* Firefox */
            appearance: none; /* General standard */
            }

            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none; /* Remove arrows in Chrome, Safari */
            margin: 0;
            }

            </style>


            <script>
                function limitLRNLength(event) {
                    const input = event.target;
                    if (input.value.length > 12) {
                        input.value = input.value.slice(0, 12); // Automatically limit to 12 digits
                    }
                }
            </script>



            {{-- Grade --}}
            <div>
                <label for="level" class="block text-sm font-medium text-gray-600">Grade</label>
                <select name="level" id="level"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="" disabled selected>-- Select Grade --</option>
                    @foreach ($grade as $gr)
                        <option value="{{ $gr->level }}" {{ old('level') == $gr->level ? 'selected' : '' }}>
                            {{ $gr->level }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <label for="guardian" class="block text-sm font-medium text-gray-600">Guardian Name</label>
                <input type="text" name="guardian" id="guardian"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    value="{{ old('guardian') }}">
            </div>
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Guardian Email</label>
                <input type="text" name="email" id="email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    value="{{ old('email') }}">
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-[#660B05] hover:bg-[#540903] text-white font-semibold py-2 px-4 rounded-md shadow">
                    Register
                </button>
            </div>
        </form>
    </div>
@endsection
