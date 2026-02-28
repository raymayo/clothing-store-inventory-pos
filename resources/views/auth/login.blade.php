<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold">Welcome back</h1>
                        <p class="mt-1 text-sm text-slate-400">Sign in to manage inventory and admin tools.</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-400"></div>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-lg border border-rose-900/60 bg-rose-950/60 px-4 py-3 text-sm text-rose-200">
                        <p class="font-medium">Login failed</p>
                        <p class="text-rose-300">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form class="mt-6 space-y-4" method="POST" action="/login">
                    @csrf
                    <div>
                        <label for="email" class="text-sm font-medium text-slate-300">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <div>
                        <label for="password" class="text-sm font-medium text-slate-300">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-100 placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2 text-slate-400">
                            <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-900">
                            Remember me
                        </label>
                        <span class="text-slate-500">Forgot password?</span>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-300">
                        Sign in
                    </button>
                </form>

                <div class="mt-6 text-xs text-slate-500">
                    Need access? Ask an admin to grant your account admin privileges.
                </div>
            </div>
        </div>
    </div>
</body>

</html>
