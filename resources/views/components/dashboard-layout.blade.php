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

        @auth
            @if (auth()->user()->is_admin)
                <x-links href="/admin">
                    Admin
                </x-links>
            @endif
        @endauth

        <x-links href="/products">
            Products
        </x-links>

        <x-links href="/categories">
            Categories
        </x-links>

        <x-links href="#">
            Customers
        </x-links>

        @auth
            <li class="mt-6 px-2">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-md bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                        Log out
                    </button>
                </form>
            </li>
        @endauth
    </x-sidebar>
    <main class="w-full">
        {{ $slot }}
    </main>
</body>

</html>
