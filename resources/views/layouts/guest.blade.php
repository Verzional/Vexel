<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vexel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="flex min-h-screen w-full bg-[#DDE1FF] overflow-hidden">

        <div class="hidden lg:flex lg:w-1/2 relative flex-col">
            
            <div class="p-12 pb-0 z-10">
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/vexel-logo.png') }}" alt="Vexel Logo" class="h-8 w-auto">
                    <span class="text-2xl font-bold text-[#764BA2] tracking-wide">Vexel</span>
                </div>

                @if (request()->routeIs('register'))
                    <h1 class="text-5xl font-bold text-[#764BA2] leading-tight tracking-tight">
                        Create your account<br>
                        and start grading<br>
                        smarter.
                    </h1>
                @else
                    <h1 class="text-5xl font-bold text-[#764BA2] leading-tight tracking-tight">
                        Welcome back.<br>
                        Streamline your grading<br>
                        with Vexel.
                    </h1>
                @endif
            </div>

            <div class="absolute bottom-0 left-0 right-0 flex items-end px-8 z-0">
                @if (request()->routeIs('register'))
                    <img src="{{ asset('images/register.png') }}" 
                         alt="Register Vexel" 
                         class="w-full max-w-xl object-contain object-bottom drop-shadow-sm">
                @else
                    <img src="{{ asset('images/login.png') }}" 
                         alt="Login Vexel" 
                         class="w-full max-w-sm object-contain object-bottom drop-shadow-sm">
                @endif
            </div>
        </div>

        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8 sm:p-12 relative z-20 shadow-[-10px_0_30px_rgba(0,0,0,0.05)] lg:rounded-l-[60px]">
            <div class="w-full max-w-md z-30">
                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>