<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Mini ERP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { 
            background-color: #111111; 
            font-family: 'Quicksand', sans-serif; 
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 text-zinc-300 selection:bg-teal-500/30">
    
    <div class="w-full max-w-md bg-zinc-900/60 backdrop-blur-xl border border-white/5 rounded-4xl p-8 sm:p-10 shadow-2xl shadow-black/50">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-teal-400 tracking-tight drop-shadow-sm mb-2">MiniERP</h1>
            <p class="text-zinc-500 font-medium">Please enter your details to register.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-950/30 border border-red-900/50 text-red-400 font-medium text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Full Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-sm font-semibold text-zinc-400 pl-1">Full Name</label>
                <input class="w-full px-4 py-3.5 bg-[#171717] border border-white/5 rounded-xl outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-white placeholder-zinc-600 font-medium shadow-inner" 
                       type="text" name="name" id="name" placeholder="Your Name" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-sm font-semibold text-zinc-400 pl-1">Email Address</label>
                <input class="w-full px-4 py-3.5 bg-[#171717] border border-white/5 rounded-xl outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-white placeholder-zinc-600 font-medium shadow-inner" 
                       type="email" name="email" id="email" placeholder="example@email.com" value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="block text-sm font-semibold text-zinc-400 pl-1">Password</label>
                <div class="relative">
                    <input class="w-full px-4 py-3.5 pr-12 bg-[#171717] border border-white/5 rounded-xl outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all text-white placeholder-zinc-600 font-medium shadow-inner" 
                           type="password" name="password" id="password" placeholder="Min. 8 characters" required>
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-zinc-600 hover:text-teal-400 transition-colors focus:outline-none">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit" class="w-full py-3.5 bg-linear-to-r from-zinc-800 to-teal-500 text-white font-bold text-lg rounded-xl shadow-lg shadow-teal-900/20 hover:opacity-90 active:scale-[0.98] transform transition-all focus:outline-none focus:ring-2 focus:ring-teal-500/50">
                    Create Account
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="mt-8 text-center text-sm font-medium text-zinc-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-teal-400 hover:text-teal-300 transition-colors ml-1">Sign in</a>
        </p>

    </div>

    <!-- Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke:linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
</body>
</html>
