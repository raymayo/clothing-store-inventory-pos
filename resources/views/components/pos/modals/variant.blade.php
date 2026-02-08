<div x-show="variantModal" x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-slate-900/40 p-4"
    @keydown.escape.window="variantModal=false">
    <div x-transition class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-black/5"
        @click.outside="variantModal=false">
        <div class="flex items-start gap-3 border-b border-slate-200 p-4">
            <img :src="selectedProduct?.image" class="h-16 w-16 rounded-2xl object-cover">
            <div class="min-w-0 flex-1">
                <div class="truncate text-sm font-semibold" x-text="selectedProduct?.name"></div>
                <div class="mt-0.5 text-xs text-slate-500">
                    <span x-text="selectedProduct?.sku"></span> • <span x-text="selectedProduct?.category"></span>
                </div>
                <div class="mt-1 text-sm font-extrabold" x-text="money(selectedProduct?.price ?? 0)"></div>
            </div>
            <button @click="variantModal=false"
                class="rounded-xl px-2 py-1 text-slate-500 hover:bg-slate-100">✕</button>
        </div>

        <div class="space-y-4 p-4">
            <div>
                <div class="mb-2 text-xs font-semibold text-slate-600">Size</div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="s in (selectedProduct?.sizes ?? ['OS'])" :key="s">
                        <button @click="pickSize(s)" :disabled="!sizeHasStock(s)"
                            :class="selectedSize === s ? 'bg-slate-900 text-white' :
                                (!sizeHasStock(s) ? 'bg-slate-50 text-slate-400 line-through cursor-not-allowed' :
                                    'bg-slate-100 text-slate-800 hover:bg-slate-200')"
                            class="rounded-2xl px-3 py-2 text-sm font-semibold disabled:opacity-60"
                            x-text="s"></button>
                    </template>
                </div>
            </div>

            <div>
                <div class="mb-2 text-xs font-semibold text-slate-600">Color</div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="c in (selectedProduct?.colors ?? ['Default'])" :key="c">
                        <button @click="pickColor(c)" :disabled="!colorHasStock(c)"
                            :class="selectedColor === c ? 'bg-indigo-600 text-white' :
                                (!colorHasStock(c) ? 'bg-slate-50 text-slate-400 line-through cursor-not-allowed' :
                                    'bg-slate-100 text-slate-800 hover:bg-slate-200')"
                            class="rounded-2xl px-3 py-2 text-sm font-semibold disabled:opacity-60"
                            x-text="c"></button>
                    </template>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Selected</span>
                    <span class="font-semibold">
                        <span x-text="selectedSize"></span> • <span x-text="selectedColor"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between border-t border-slate-200 p-4">
            <div class="text-xs text-slate-500">
                Stock: <span class="font-semibold text-slate-700" x-text="variantStock()"></span>
            </div>
            <button @click="confirmAdd()" :disabled="variantStock() <= 0"
                class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed">
                Add to cart
            </button>
        </div>
    </div>
</div>
