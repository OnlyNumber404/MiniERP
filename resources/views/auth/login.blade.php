<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="{{asset('js/password.js')}}"></script>
    @vite('resources/css/app.css')
</head>
<body class="flex">
    <main>
        <form class="border-2 flex items-center justify-center h-screen w-3xl" action="" method="POST">
            <div class="login-container border-2 border-gray-400 p-6 rounded-3xl">
                @csrf
                <div class="text text-center mb-5">
                    <h1 class="font-Quicksand font-bold text-2xl">Welcome Back!</h1>
                    <h3 class="font-Quicksand ">Don't have an account yet? <a class="font-bold hover:text-blue-500" href="/signup">Sign-up</a></h3>
                </div>
                {{-- email --}}
                @if (@session('failed'))
                    <div class="text-red-500">{{session('failed')}}</div>
                @endif
                <div class="email-container w-full h-12 mb-5 border-2 border-gray-400 rounded-2xl hover:border-gray-700 transition-all duration-200 flex">
                    <input class="outline-0 w-full h-full p-3 rounded-2xl" type="email" name="email" id="email" placeholder="Email or Username" value="{{old('email')}}">
                    <div class="flex items-center p-2">
                        <img src="{{asset('photos/mail.png')}}" alt="email">
                    </div>
                </div>
                {{-- password --}}
                <div class="password-container w-full h-12 mb-5 border-2 border-gray-400 rounded-2xl hover:border-gray-700 transition-all duration-200 flex">
                    <input class="outline-0 w-full h-full p-3 rounded-2xl" type="password" name="password" id="password" placeholder="Password">
                    <div class="show-password flex items-center p-2">
                        <img id="pw-icon" src="{{asset('photos/password-show.png')}}" alt="password">
                    </div>
                </div>
                <div class="login-button text-center w-full h-10">
                    <button class="border-2 border-gray-500 rounded-2xl w-full h-full hover:cursor-pointer font-Quicksand font-bold" type="submit">Login</button>
                </div>
            </div>
        </form>
    </main>
    <aside class="border-2">
    </aside>
    <script>
        const toggle = document.querySelector('.show-password');
        const password = document.querySelector('#password');
        const icon = document.querySelector('#pw-icon');

        toggle.addEventListener('click', function(){

            if(password.type === "password"){
                password.type = "text";
                icon.src = "{{ asset('photos/password-hide.png') }}";
            } else {
                password.type = "password";
                icon.src = "{{ asset('photos/password-show.png') }}";
            }

        });
    </script>
</body>
</html>