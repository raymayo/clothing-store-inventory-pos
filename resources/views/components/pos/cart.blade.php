<aside class="col-span-12 md:col-span-3 lg:col-span-3">
    <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-4 py-3">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Cart</div>
                    <div class="text-xs text-slate-500">
                        <span x-text="cartCount"></span> items •
                        <span class="font-semibold text-slate-700" x-text="money(total())"></span>
                    </div>
                </div>
                <button @click="clearCart()"
                    class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                    Clear
                </button>
            </div>
        </div>

        {{-- Customer --}}
        <div class="border-b border-slate-200 p-4">
            <div class="mb-2 text-xs font-semibold text-slate-600">Customer</div>
            <div class="grid grid-cols-2 gap-2">
                <input x-model="customer.name" type="text" placeholder="Name"
                    class="col-span-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                <input x-model="customer.phone" type="text" placeholder="Phone"
                    class="col-span-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
            </div>
        </div>

        {{-- Items --}}
        <div class="flex-1 overflow-auto p-3">
            <template x-for="item in cart" :key="item.key">
                <div class="mb-3 rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                    <div class="flex gap-3">
                        <img :src="item.image" class="h-14 w-14 rounded-2xl object-cover">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="truncate text-sm font-semibold" x-text="item.name"></div>
                                    <div class="mt-0.5 text-xs text-slate-500">
                                        <span x-text="item.sku"></span>
                                        <span class="mx-1">•</span>
                                        <span x-text="item.size || 'OS'"></span>
                                        <span class="mx-1">•</span>
                                        <span x-text="item.color || '—'"></span>
                                    </div>
                                </div>
                                <button @click="removeItem(item.key)"
                                    class="rounded-xl px-2 py-1 text-slate-500 hover:bg-slate-100" title="Remove">
                                    ✕
                                </button>
                            </div>

                            <div class="mt-2 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <button @click="dec(item.key)"
                                        class="h-9 w-9 rounded-2xl bg-slate-100 text-sm font-semibold hover:bg-slate-200">−</button>
                                    <div class="min-w-[2.5rem] text-center text-sm font-semibold" x-text="item.qty">
                                    </div>
                                    <button @click="inc(item.key)"
                                        class="h-9 w-9 rounded-2xl bg-slate-100 text-sm font-semibold hover:bg-slate-200">+</button>
                                </div>
                                <div class="text-sm font-semibold text-slate-900" x-text="money(item.qty * item.price)">
                                </div>
                            </div>

                            <div class="mt-2">
                                <input x-model="item.note" type="text" placeholder="Item note (e.g., gift wrap)"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="cart.length === 0" class="grid place-items-center py-14 text-center">
                <div class="max-w-xs">
                    <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-2xl bg-slate-100">
                        <svg class="h-6 w-6 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 6h15l-1.5 9h-12z" />
                            <path d="M6 6l-2 0" />
                            <circle cx="9" cy="20" r="1" />
                            <circle cx="18" cy="20" r="1" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold">Cart is empty</div>
                    <div class="mt-1 text-xs text-slate-500">Add items from the product grid.</div>
                </div>
            </div>
        </div>

        {{-- Totals + Checkout --}}
        <div class="border-t border-slate-200 p-4">
            <div class="mb-3 grid grid-cols-2 gap-2">
                <div class="rounded-2xl bg-slate-50 p-3">
                    <div class="text-xs text-slate-500">Discount</div>
                    <div class="mt-1 flex items-center gap-2">
                        <input x-model.number="discount" type="number" min="0"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                        <span class="text-xs font-semibold text-slate-600">₱</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-slate-50 p-3">
                    <div class="text-xs text-slate-500">Tax</div>
                    <div class="mt-1 flex items-center gap-2">
                        <input x-model.number="taxRate" type="number" min="0" max="50" step="0.1"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                        <span class="text-xs font-semibold text-slate-600">%</span>
                    </div>
                </div>
            </div>

            <div class="space-y-2 rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Subtotal</span>
                    <span class="font-semibold" x-text="money(subtotal())"></span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Discount</span>
                    <span class="font-semibold text-rose-600" x-text="'− ' + money(discountApplied())"></span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Tax</span>
                    <span class="font-semibold" x-text="money(taxAmount())"></span>
                </div>
                <div class="flex items-center justify-between border-t border-slate-200 pt-2 text-sm">
                    <span class="text-slate-900 font-semibold">Total</span>
                    <span class="text-lg font-extrabold tracking-tight" x-text="money(total())"></span>
                </div>

                <button @click="openCheckout()" :disabled="cart.length === 0"
                    class="mt-2 w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-fuchsia-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:from-indigo-700 hover:to-fuchsia-700 disabled:cursor-not-allowed disabled:opacity-40">
                    Checkout
                </button>

                <div class="text-[11px] text-slate-500">
                    Tip: Tap a product to select size/color.
                </div>
            </div>
        </div>
    </div>
</aside>
