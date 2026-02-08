<aside class="col-span-12 md:col-span-3 lg:col-span-2">
    <div class="h-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-4 py-3">
            <div class="text-sm font-semibold">Catalog</div>
            <div class="text-xs text-slate-500">Filter by category</div>
        </div>

        <div class="flex h-[calc(100%-60px)] flex-col">
            <div class="p-3">
                <button @click="activeCategory = 'All'"
                    :class="activeCategory === 'All' ? 'bg-indigo-600 text-white' :
                        'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="w-full rounded-2xl px-3 py-2 text-left text-sm font-semibold">
                    All Items
                    <span class="float-right rounded-full bg-white/20 px-2 py-0.5 text-xs"
                        x-text="filteredCount('All')"></span>
                </button>
            </div>

            <div class="flex-1 overflow-auto px-3 pb-3">
                <template x-for="cat in categories" :key="cat">
                    <button @click="activeCategory = cat"
                        :class="activeCategory === cat ? 'bg-indigo-600 text-white' :
                            'bg-white text-slate-700 hover:bg-slate-50'"
                        class="mb-2 flex w-full items-center justify-between rounded-2xl border border-slate-200 px-3 py-2 text-left text-sm font-semibold shadow-sm">
                        <span x-text="cat"></span>
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600"
                            x-text="filteredCount(cat)"
                            :class="activeCategory === cat ? 'bg-white/20 text-white' : ''"></span>
                    </button>
                </template>

                <div class="mt-4 rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-3">
                    <div class="mb-2 text-xs font-semibold text-slate-600">Quick Filters</div>

                    <label class="flex items-center justify-between rounded-xl bg-white px-3 py-2 text-sm shadow-sm">
                        <span class="text-slate-700">In stock only</span>
                        <input type="checkbox" x-model="inStockOnly"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                    </label>

                    <div class="mt-2">
                        <div class="mb-1 text-xs font-semibold text-slate-600">Sort</div>
                        <select x-model="sortBy"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                            <option value="featured">Featured</option>
                            <option value="price_asc">Price: Low → High</option>
                            <option value="price_desc">Price: High → Low</option>
                            <option value="name_asc">Name: A → Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
