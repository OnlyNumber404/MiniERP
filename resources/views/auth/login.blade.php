<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body class="flex">
    <main>
        <form class="border-2 flex items-center justify-center h-screen w-3xl" action="" method="POST">
            @csrf
            <div class="login-container border-2 border-gray-400 p-6 rounded-3xl">
                <div class="text text-center mb-5">
                    <h1 class="font-Quicksand font-bold text-2xl">Welcome Back!</h1>
                    <h3 class="font-Quicksand ">Don't have an account yet? <a class="font-bold hover:text-blue-500" href="/signup">Sign-up</a></h3>
                </div>
                <div class="email-container w-full h-12 mb-5">
                    <input class="outline-0 border-2 border-gray-400 w-full h-full rounded-2xl p-3 hover:border-gray-700 transition-all duration-200" class="" type="email" name="email" id="email" placeholder="Email or Username">
                </div>
                <div class="password-container w-full h-12 mb-5">
                    <input class="outline-0 border-2 border-gray-400 w-full h-full rounded-2xl p-3 hover:border-gray-700 transition-all duration-200" type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="login-button text-center w-full h-10">
                    <button class="border-2 border-gray-500 rounded-2xl w-full h-full hover:cursor-pointer font-Quicksand font-bold" type="submit">Login</button>
                </div>
            </div>
        </form>
    </main>
    <aside class="border-2">
    </aside>
</body>
</html>