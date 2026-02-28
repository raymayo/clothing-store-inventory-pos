<x-dashboard-layout title="Create Admin">
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-xl px-6 py-10">
            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-1">
                    <h1 class="text-2xl font-semibold text-slate-900">Create Admin</h1>
                    <p class="text-sm text-slate-600">Add a new admin user for the system.</p>
                </div>

                @if (session('status'))
                    <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <p class="font-medium">Please fix the following:</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.store') }}">
                    @csrf

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700" for="name">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700" for="password">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700" for="password_confirmation">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                            required
                        >
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500"
                        >
                            Create Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
