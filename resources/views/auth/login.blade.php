<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#f2f2f2]  ">


    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-10 relative">

            <div class="absolute top-4 left-4 ">
                <img src="{{ asset('images/logo/sanhs.jpg') }}" alt="Logo" class="h-15 w-auto ">
            </div>
    

            <h2 class="text-2xl font-bold text-center mb-15">Login</h2>
            <form  action=" {{ route('loginPost') }} " method="POST"class="space-y-4">
                @csrf
        
               
                <div class="mt-2">
                    <label for="username" class="block font-medium">Username</label>
                    <input type="text" class="mt-1 block border-b-1 w-full focus:outline-none"
                    name="username" >
                </div>
               
                <div class="mt-2">
                    <label for="password" class="block font-medium">Password</label>
                    <input type="password" class="mt-1 block border-b-1 w-full focus:outline-none"
                    name="password" >
                </div>

                <div class="mt-2">
                    <button class="bg-red-800 text-white font-medium w-full py-2 rounded-lg hover:bg-red-900">
                        Login
                    </button>
                </div>
        
            </form>
        </div>
    </div>
    
      
    




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
    
</body>
</html>