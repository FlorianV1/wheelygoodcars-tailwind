<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WheelyGoodCars') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
<nav class="bg-white border-b shadow mb-6">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-700">WheelyGoodCars</a>
        <div class="space-x-4">
            @auth
                <a href="{{ route('cars.my') }}" class="text-blue-700 hover:underline">Mijn auto's</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-red-600 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-blue-700 hover:underline">Registreer</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-xl mx-auto px-4">
    @yield('content')
</main>
</body>
</html>
