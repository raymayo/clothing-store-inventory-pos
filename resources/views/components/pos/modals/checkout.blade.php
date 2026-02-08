<div x-show="checkoutModal" x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-slate-900/40 p-4"
    @keydown.escape.window="checkoutModal=false">
    <div x-transition class="w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-black/5"
        @click.outside="checkoutModal=false">
        <div class="border-b border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Checkout</div>
                    <div class="text-xs text-slate-500">Select payment method and finalize</div>
                </div>
                <button @click="checkoutModal=false"
                    class="rounded-xl px-2 py-1 text-slate-500 hover:bg-slate-100">✕</button>
            </div>
        </div>

        <div class="space-y-4 p-4">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Amount Due</span>
                    <span class="text-xl font-extrabold" x-text="money(total())"></span>
                </div>
            </div>

            <div>
                <div class="mb-2 text-xs font-semibold text-slate-600">Payment Method</div>
                <div class="grid grid-cols-3 gap-2">
                    <template x-for="m in ['Cash','Card','E-Wallet']" :key="m">
                        <button @click="payment.method = m"
                            :class="payment.method === m ? 'bg-indigo-600 text-white' :
                                'bg-white text-slate-800 hover:bg-slate-50'"
                            class="rounded-2xl border border-slate-200 px-3 py-2 text-sm font-semibold shadow-sm"
                            x-text="m"></button>
                    </template>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="rounded-2xl border border-slate-200 p-3">
                    <div class="text-xs font-semibold text-slate-600">Tendered</div>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-sm font-semibold text-slate-500">₱</span>
                        <input x-model.number="payment.tendered" type="number" min="0"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                    </div>
                    <div class="mt-2 text-[11px] text-slate-500">For Cash: enter amount received.</div>
                </div>
                <div class="rounded-2xl border border-slate-200 p-3">
                    <div class="text-xs font-semibold text-slate-600">Change</div>
                    <div class="mt-2 text-lg font-extrabold" x-text="money(change())"></div>
                    <div class="mt-2 text-[11px] text-slate-500">If negative, amount still due.</div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 p-3">
                <div class="text-xs font-semibold text-slate-600">Reference / Notes</div>
                <input x-model="payment.ref" type="text" placeholder="Optional (e.g., last 4 digits / ref no.)"
                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
            </div>
        </div>

        <div class="flex items-center justify-between gap-2 border-t border-slate-200 p-4">
            <button @click="checkoutModal=false"
                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                Back
            </button>
            <button @click="completeSale()"
                class="w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:from-emerald-700 hover:to-teal-700">
                Complete Sale
            </button>
        </div>
    </div>
</div>
