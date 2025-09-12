@extends('layout')
@section('title', 'Edit Student')
@section('pagetitle', 'Edit Student')

@section('main')
    <div class="p-6 bg-white w-full max-w-2xl mx-auto rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Student</h2>

        {{-- Show validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action=" {{ route('updateStudent', $student->id) }} " method="POST" class="space-y-4">
            
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600">Full Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required value=" {{ old('name', $student->name) }} ">
            </div>

            {{-- Age --}}
            <div>
                <label for="age" class="block text-sm font-medium text-gray-600">Age</label>
                <input type="number" name="age" id="age" min="1" max="100"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required value="{{ old('age', $student->age) }}">
            </div>

            {{-- Gender --}}
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-600">Gender</label>
                <select name="gender" id="gender"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required>
                    <option value="" disabled selected>-- Select Gender --</option>
                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                <textarea name="address" id="address" rows="2"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required>{{ old('address', $student->address) }}</textarea>
            </div>

            {{-- LRN --}}
            <div>
                <label for="lrn" class="block text-sm font-medium text-gray-600">LRN (12 digits)</label>
                <input type="text" name="lrn" id="lrn" maxlength="12" pattern="\d{12}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    placeholder="Enter 12-digit LRN" required value="{{ old('lrn', $student->lrn) }}">
                <p class="text-xs text-gray-500">Must be exactly 12 digits</p>
            </div>

            {{-- Grade --}}
            <div>
                <label for="level" class="block text-sm font-medium text-gray-600">Grade</label>
                <select name="level" id="level"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    required>
                    <option value="" disabled selected>-- Select Grade --</option>
                    @foreach ($grade as $gr)
                        <option value="{{ $gr->level }}" {{ old('level', $student->level) == $gr->level ? 'selected' : '' }}>
                            {{ $gr->level }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
