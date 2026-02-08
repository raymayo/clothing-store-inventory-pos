<!doctype html>
<html lang="en">

<head>
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex">
    <x-sidebar title="Dashboard">
        <x-links href="/dashboard" active>
            Dashboard
        </x-links>

        <x-links href="/products">
            Products
        </x-links>

        <x-links href="/categories">
            Categories
        </x-links>

        <x-links href="#">
            Customers
        </x-links>
    </x-sidebar>
    <main class="w-full">
        {{ $slot }}
    </main>
</body>

</html>
