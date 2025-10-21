<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col font-sans text-[#111827]">

    <header class="bg-[#660B05] shadow-md p-3 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo/sanhs-nobg.png') }}" alt="Logo" class="h-12 w-auto">
            <h2 class="text-2xl font-semibold text-[#F5E5D0]">@yield('pagetitle')</h2>
        </div>
        
        <div class="flex items-center gap-4">
            <div>
                <a href="{{ route('home') }}"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition">Home</a>
            </div>

            <div>
                <a href="{{ route('attendanceIndex') }}"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition ml-8">Attendance</a>
            </div>

            <div>
                <a href=" {{ route('qrTesterIndex') }} "
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition ml-8">Qr Tester</a>
            </div>
    
            <div>
                <select id="dropdown"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition text-center">
                    <option value="" selected disabled>Student</option>
                    <option value=" {{ route('studentList') }} ">Student List</option>
                    <option value="{{ route('register') }}">Register Student</option>
                    <option value=" {{ route('recentlyDeleted') }} ">Recently Deleted</option>
                </select>
            </div>
    
            <div>
                <select id="level"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition text-center">
                    <option value="" selected disabled>Grade & Section</option>
                    <option value="{{ route('level') }}">List</option>
                </select>
            </div>
{{-- 
            <div>
                <a href="{{ route('changePasswordIndex') }}"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition">Settings</a>
            </div> --}}

              <div>
                <select id="settings"
                    class="font-semibold text-gray-300 hover:text-gray-500 duration-200 transition text-center">
                    <option value="" selected disabled>Settings</option>
                    <option value="{{ route('changePasswordIndex') }}">Change Password</option>
                    <option value="{{ route('backupIndex') }}">Back Up</option>
                </select>
            </div>
    
            <form action=" {{ route('logout') }} " method="POST">
                @csrf
                <button type="submit"
                    class="text-sm bg-red-500 text-white px-3 py-1 hover:bg-red-600 transition duration-200 rounded-md">Logout</button>
            </form>
        </div>
    </header>
    

    <main class="flex-1 p-6">
        @yield('main')
    </main>


    <script>
        document.getElementById('dropdown').addEventListener('change', function() {
            const url = this.value;
            if (url) {
                window.location.href = url;
            }
        });
    </script>

    <script>
        document.getElementById('level').addEventListener('change', function() {
            const url = this.value;
            if (url) {
                window.location.href = url;
            }
        });
    </script>

     <script>
        document.getElementById('settings').addEventListener('change', function() {
            const url = this.value;
            if (url) {
                window.location.href = url;
            }
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: @json(session('success'))
                })
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: @json(session('error'))
                })
            @endif

            @if (session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: @json(session('warning'))
                })
            @endif

            @if (session('info'))
                Toast.fire({
                    icon: 'info',
                    title: @json(session('info'))
                })
            @endif

            @if (session('question'))
                Toast.fire({
                    icon: 'question',
                    title: @json(session('question'))
                })
            @endif

            @foreach($errors->all() as $error)
                Toast.fire({
                    icon: 'warning',
                    title: @json($error)
                })
            @endforeach
        });
    </script>
    
    @stack('scripts')
    
    

</body>

</html>
