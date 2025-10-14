@extends('layout')
@section('title', 'Back Up')
@section('pagetitle', 'Back Up')

@section('main')
<div class="min-h-[80%] flex items-center justify-center px-4 bg-gray-50">
    <div class="bg-white shadow-md rounded-xl p-8 max-w-md w-full border border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800 mb-3 text-center">Database Backup</h2>
        <p class="text-gray-600 text-center mb-6">Safely backup your database. Make sure you have enough storage before running the backup.</p>

        <form action="{{ route('backup.run') }}" method="POST">
            @csrf
            <button 
                type="submit" 
                class="flex items-center justify-center w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-3 px-5 rounded-lg shadow-sm transition duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V3m0 0L8 7m4-4l4 4"/>
                </svg>
                Backup Database
            </button>
        </form>
    </div>
</div>
@endsection
