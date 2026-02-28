<x-dashboard-layout title="Admin">
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-6 py-10">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Admin Control Room</h1>
                    <p class="text-sm text-slate-600">Manage users, roles, and system settings.</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="text-base font-semibold text-slate-900">User Access</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Promote staff to admin, reset passwords, and manage roles.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-2 py-1">Placeholder</span>
                        <span>Hook up user management later.</span>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="text-base font-semibold text-slate-900">System Settings</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Configure store details, tax rates, and integrations.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-2 py-1">Placeholder</span>
                        <span>Wire settings form when ready.</span>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="text-base font-semibold text-slate-900">Audit Log</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Track changes across inventory, pricing, and access control.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-2 py-1">Placeholder</span>
                        <span>Connect to activity stream.</span>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h2 class="text-base font-semibold text-slate-900">Emergency Tools</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Maintenance mode, cache resets, and backups.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-2 py-1">Placeholder</span>
                        <span>Keep these behind admin controls.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
