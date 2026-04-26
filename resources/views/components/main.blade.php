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

<body id="theme-body" class="text-white font-sans antialiased">
    <div class="h-screen w-full flex">
        <!-- Sidebar container -->
        <aside class="w-60 h-full flex flex-col py-8 px-5 border-r border-[#121212] bg-[#121212] overflow-y-auto custom-scrollbar">
            <!--Logo-->
            <div class="px-3 py-3 text-center mb-4 rounded-3xl">
                <p class="font-Quicksand font-bold text-3xl bg-linear-to-r from-teal-200 to-teal-500 bg-clip-text text-transparent ">MiniERP</p>
            </div>
            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1">
                <!--dashboard-->
                <x-nav href="/" :active="request()->is('/')">
                    <!-- Dashboard Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span class="font-medium text-[15px]">Dashboard</span>
                </x-nav>
                <!--Transaksi-->
                <x-nav href="/transaction" :active="request()->is('transaction')">
                    <!-- Transaction Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    <span class="font-medium text-[15px]">Transaksi</span>
                </x-nav>
                <!--Kategori-->
                <x-nav href="/category" :active="request()->is('category')">
                    <!-- Category Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.125 1.125 0 001.591 0l7.218-7.218a1.125 1.125 0 000-1.591L11.859 3.659A2.25 2.25 0 0010.268 3zM6.75 6.75h.008v.008H6.75V6.75z" />
                    </svg>
                    <span class="font-medium text-[15px]">Kategori</span>
                </x-nav>
                <!--Analisa-->
                <x-nav href="/analisa" :active="request()->is('analisa')">
                    <!-- Analisa Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-[15px]">Analisa</span>
                </x-nav>
        </aside>

        <!-- Main Content Layout Area -->
        <main class="flex-1 overflow-y-visible overflow-hidden p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 font-Quicksand">
                    {{$head}}
                </h1>
                @auth    
                <div class="flex items-center space-x-4">
                    <div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="border border-red-500 text-red-500 px-3 py-1 rounded hover:bg-red-500 hover:text-white transition text-sm flex items-center hover:cursor-pointer">Logout</button>
                        </form>
                    </div>
                    <span class="text-sm font-medium text-gray-600">Halo, {{Auth::user()->name}}</span>
                    <div class="w-10 h-10 rounded-full bg-amber-700"></div>
                </div>
                @endauth
            </header>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
