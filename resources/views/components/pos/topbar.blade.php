<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 backdrop-blur">
    <div class="mx-auto flex max-w-[1600px] items-center gap-3 px-4 py-3">
        <div class="flex items-center gap-2">
            <div
                class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-indigo-600 to-fuchsia-600 text-white shadow-sm">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 4l3 3v3l-3-1v12H8V9L5 10V7l3-3c1 1 2 2 4 2s3-1 4-2z" />
                </svg>
            </div>
            <div class="leading-tight">
                <div class="text-sm font-semibold tracking-tight">Threads & Co.</div>
                <div class="text-xs text-slate-500">POS Terminal • Counter 1</div>
            </div>
        </div>

        <div class="ml-auto flex items-center gap-2">
            <div class="relative w-[min(520px,55vw)]">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-4.3-4.3" />
                        <circle cx="11" cy="11" r="7" />
                    </svg>
                </div>
                <input x-model.debounce.150ms="query" type="text" placeholder="Search SKU, name, color…"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-10 py-2.5 text-sm shadow-sm outline-none ring-indigo-600/20 placeholder:text-slate-400 focus:ring-4" />
                <button x-show="query.length" @click="query=''"
                    class="absolute inset-y-0 right-2 my-auto rounded-xl px-2 text-slate-500 hover:bg-slate-100"
                    title="Clear">
                    ✕
                </button>
            </div>

            <button @click="newSale()"
                class="rounded-2xl bg-slate-900 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                New Sale
            </button>
            <button @click="holdSale()"
                class="rounded-2xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                Hold
            </button>
        </div>
    </div>
</header>
