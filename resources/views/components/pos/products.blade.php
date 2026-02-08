<section class="col-span-12 md:col-span-6 lg:col-span-7">
    <div class="h-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
            <div>
                <div class="text-sm font-semibold">Products</div>
                <div class="text-xs text-slate-500">
                    <span x-text="activeCategory"></span>
                    • <span x-text="visibleProducts.length"></span> items
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click="grid = 3"
                    :class="grid === 3 ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="rounded-xl px-3 py-2 text-xs font-semibold" title="Compact grid">3</button>
                <button @click="grid = 4"
                    :class="grid === 4 ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="rounded-xl px-3 py-2 text-xs font-semibold" title="Comfort grid">4</button>
                <button @click="grid = 5"
                    :class="grid === 5 ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="rounded-xl px-3 py-2 text-xs font-semibold" title="Dense grid">5</button>
            </div>
        </div>

        <div class="h-[calc(100%-60px)] overflow-auto p-4">
            <div class="grid gap-3"
                :class="grid === 3 ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' : (grid === 4 ?
                    'grid-cols-2 sm:grid-cols-3 lg:grid-cols-4' : 'grid-cols-2 sm:grid-cols-4 lg:grid-cols-5')">
                <template x-for="p in visibleProducts" :key="p.id">
                    <button @click="openVariant(p)"
                        class="group overflow-hidden rounded-3xl border border-slate-200 bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-indigo-600/20">
                        <div class="relative">
                            <img :src="p.image" :alt="p.name" class="h-36 w-full object-cover">
                            <div
                                class="absolute left-3 top-3 rounded-full bg-white/90 px-2 py-1 text-xs font-semibold text-slate-800 shadow-sm">
                                <span x-text="money(p.price)"></span>
                            </div>
                            <div class="absolute right-3 top-3 rounded-full px-2 py-1 text-xs font-semibold shadow-sm"
                                :class="p.stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'">
                                <span x-text="p.stock > 0 ? (p.stock + ' in stock') : 'Out of stock'"></span>
                            </div>
                        </div>

                        <div class="p-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="truncate text-sm font-semibold text-slate-900" x-text="p.name"></div>
                                    <div class="mt-0.5 text-xs text-slate-500">
                                        <span x-text="p.sku"></span> • <span x-text="p.category"></span>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    <span x-text="p.sizes?.length ? p.sizes.join(' ') : 'OS'"></span>
                                </div>
                            </div>

                            <div class="mt-2 flex flex-wrap gap-1.5">
                                <template x-for="c in (p.colors ?? []).slice(0,4)" :key="c">
                                    <span
                                        class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700"
                                        x-text="c"></span>
                                </template>
                                <span x-show="(p.colors ?? []).length > 4"
                                    class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-500">
                                    +<span x-text="(p.colors.length - 4)"></span>
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="text-xs text-slate-500">Tap to add</div>
                                <div
                                    class="inline-flex items-center gap-1 rounded-2xl bg-indigo-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm group-hover:bg-indigo-700">
                                    Add
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </button>
                </template>
            </div>

            <div x-show="visibleProducts.length === 0" class="grid place-items-center py-24 text-center">
                <div class="max-w-sm">
                    <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-2xl bg-slate-100">
                        <svg class="h-6 w-6 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.3-4.3" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold">No results</div>
                    <div class="mt-1 text-xs text-slate-500">Try a different keyword or category.</div>
                </div>
            </div>
        </div>
    </div>
</section>
