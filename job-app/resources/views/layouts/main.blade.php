<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Shaghalni' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Floating Background Shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="absolute top-[15%] left-[-10%] md:left-[-5%] w-[600px] h-[140px] rotate-12 gradient-bg bg-indigo-500/15 blur-2xl rounded-full">
        </div>
        <div
            class="absolute top-[70%] right-[-5%] md:right-[0%] w-[500px] h-[120px] -rotate-15 gradient-bg bg-rose-500/15 blur-2xl rounded-full">
        </div>
        <div
            class="absolute bottom-[5%] left-[5%] md:left-[10%] w-[300px] h-[80px] -rotate-8 gradient-bg bg-violet-500/15 blur-2xl rounded-full">
        </div>
        <div
            class="absolute top-[10%] right-[15%] md:right-[20%] w-[200px] h-[60px] rotate-20 gradient-bg bg-amber-500/15 blur-2xl rounded-full">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center">
        {{ $slot }}
    </div>

    <!-- Bottom Gradient -->
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/80 pointer-events-none"></div>

</body>
</html> 