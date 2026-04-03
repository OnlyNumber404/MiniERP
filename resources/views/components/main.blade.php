<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{$title}}</title>
    @vite('resources/css/app.css')
</head>

<body id="theme-body" class="bg-[#111111] text-white font-sans antialiased">
    <div class="h-screen w-full flex">
        <!-- Sidebar container -->
        <aside class="w-60 h-full flex flex-col py-8 px-5 border-r border-[#1f1f1f] bg-[#0a0a0a] overflow-y-auto custom-scrollbar">
            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1">
                <!--dashboard-->
                <x-nav href="/" :active="request()->is('/')">
                    <!-- dashboard icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="font-medium text-[15px]">Dashboard</span>
                </x-nav>
                <!--Transaksi-->
                <x-nav href="/transaksi" :active="request()->is('transaksi')">
                    <!-- Transaksi Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                    <span class="font-medium text-[15px]">Transaksi</span>
                </x-nav>
                <!--Kategori-->
                <x-nav href="/kategori" :active="request()->is('kategori')">
                    <!-- Kategori Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                    <span class="font-medium text-[15px]">Kategori</span>
                </x-nav>
        </aside>

        <!-- Main Content Layout Area -->
        <main class="flex-1 overflow-y-visible overflow-hidden">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
