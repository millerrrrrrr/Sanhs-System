@extends('layout')
@section('title', 'Change Password')
@section('pagetitle', 'Change Password')

@section('main')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <form action="#" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Old Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Old Password</label>
            <input type="text" name="current_password" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    ">
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="text" name="password" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    >
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="text" name="password_confirmation" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                   >
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" 
                    class="w-full bg-[#660B05] hover:bg-[#4f0904] text-white font-semibold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Change Password
            </button>
        </div>
    </form>
</div>
@endsection
