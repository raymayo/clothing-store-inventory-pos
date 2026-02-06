@extends('layouts.app', ['title' => 'POS — Clothing Store'])

@section('content')
    <div x-data="pos(@js($products), @js($categories))" x-cloak class="h-screen overflow-hidden">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-[1600px] items-center gap-3 px-4 py-3">
                <div class="flex items-center gap-2">
                    <div
                        class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-indigo-600 to-fuchsia-600 text-white shadow-sm">
                        <!-- Simple T-shirt icon -->
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
                    <!-- Search -->
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

                    <!-- Quick actions -->
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

        <!-- Main -->
        <main class="mx-auto grid h-[calc(100vh-64px)] max-w-[1600px] grid-cols-12 gap-4 px-4 py-4">
            <!-- Left: Categories / Filters -->
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

                            <div
                                class="mt-4 rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-3">
                                <div class="mb-2 text-xs font-semibold text-slate-600">Quick Filters</div>
                                <label
                                    class="flex items-center justify-between rounded-xl bg-white px-3 py-2 text-sm shadow-sm">
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

            <!-- Center: Product Grid -->
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
                                :class="grid === 3 ? 'bg-slate-900 text-white' :
                                    'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                                class="rounded-xl px-3 py-2 text-xs font-semibold" title="Compact grid">3</button>
                            <button @click="grid = 4"
                                :class="grid === 4 ? 'bg-slate-900 text-white' :
                                    'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                                class="rounded-xl px-3 py-2 text-xs font-semibold" title="Comfort grid">4</button>
                            <button @click="grid = 5"
                                :class="grid === 5 ? 'bg-slate-900 text-white' :
                                    'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                                class="rounded-xl px-3 py-2 text-xs font-semibold" title="Dense grid">5</button>
                        </div>
                    </div>

                    <div class="h-[calc(100%-60px)] overflow-auto p-4">
                        <div class="grid gap-3"
                            :class="grid === 3 ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' : (grid === 4 ?
                                'grid-cols-2 sm:grid-cols-3 lg:grid-cols-4' :
                                'grid-cols-2 sm:grid-cols-4 lg:grid-cols-5')">
                            <template x-for="p in visibleProducts" :key="p.id">
                                <button @click="openVariant(p)"
                                    class="group overflow-hidden rounded-3xl border border-slate-200 bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-indigo-600/20">
                                    <div class="relative">
                                        <img :src="p.image" :alt="p.name"
                                            class="h-36 w-full object-cover">
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
                                                <div class="truncate text-sm font-semibold text-slate-900"
                                                    x-text="p.name"></div>
                                                <div class="mt-0.5 text-xs text-slate-500">
                                                    <span x-text="p.sku"></span> • <span x-text="p.category"></span>
                                                </div>
                                            </div>
                                            <div
                                                class="rounded-xl bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
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
                                            <div class="text-xs text-slate-500">
                                                Tap to add
                                            </div>
                                            <div
                                                class="inline-flex items-center gap-1 rounded-2xl bg-indigo-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm group-hover:bg-indigo-700">
                                                Add
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
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
                                    <svg class="h-6 w-6 text-slate-500" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
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

            <!-- Right: Cart -->
            <aside class="col-span-12 md:col-span-3 lg:col-span-3">
                <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold">Cart</div>
                                <div class="text-xs text-slate-500">
                                    <span x-text="cartCount"></span> items • <span class="font-semibold text-slate-700"
                                        x-text="money(total())"></span>
                                </div>
                            </div>
                            <button @click="clearCart()"
                                class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                Clear
                            </button>
                        </div>
                    </div>

                    <!-- Customer -->
                    <div class="border-b border-slate-200 p-4">
                        <div class="mb-2 text-xs font-semibold text-slate-600">Customer</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input x-model="customer.name" type="text" placeholder="Name"
                                class="col-span-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                            <input x-model="customer.phone" type="text" placeholder="Phone"
                                class="col-span-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                        </div>
                    </div>

                    <!-- Items -->
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
                                                class="rounded-xl px-2 py-1 text-slate-500 hover:bg-slate-100"
                                                title="Remove">
                                                ✕
                                            </button>
                                        </div>

                                        <div class="mt-2 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <button @click="dec(item.key)"
                                                    class="h-9 w-9 rounded-2xl bg-slate-100 text-sm font-semibold hover:bg-slate-200">−</button>
                                                <div class="min-w-[2.5rem] text-center text-sm font-semibold"
                                                    x-text="item.qty"></div>
                                                <button @click="inc(item.key)"
                                                    class="h-9 w-9 rounded-2xl bg-slate-100 text-sm font-semibold hover:bg-slate-200">+</button>
                                            </div>
                                            <div class="text-sm font-semibold text-slate-900"
                                                x-text="money(item.qty * item.price)"></div>
                                        </div>

                                        <div class="mt-2">
                                            <input x-model="item.note" type="text"
                                                placeholder="Item note (e.g., gift wrap)"
                                                class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm focus:ring-4 focus:ring-indigo-600/20">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="cart.length === 0" class="grid place-items-center py-14 text-center">
                            <div class="max-w-xs">
                                <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-2xl bg-slate-100">
                                    <svg class="h-6 w-6 text-slate-500" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
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

                    <!-- Totals + Checkout -->
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
                                    <input x-model.number="taxRate" type="number" min="0" max="50"
                                        step="0.1"
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
        </main>

        <!-- Variant Picker Modal -->
        <div x-show="variantModal" x-transition.opacity
            class="fixed inset-0 z-50 grid place-items-center bg-slate-900/40 p-4"
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
                                    :class="selectedSize === s ?
                                        'bg-slate-900 text-white' :
                                        (!sizeHasStock(s) ?
                                            'bg-slate-50 text-slate-400 line-through cursor-not-allowed' :
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
                                    :class="selectedColor === c ?
                                        'bg-indigo-600 text-white' :
                                        (!colorHasStock(c) ?
                                            'bg-slate-50 text-slate-400 line-through cursor-not-allowed' :
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

        <!-- Checkout Modal -->
        <div x-show="checkoutModal" x-transition.opacity
            class="fixed inset-0 z-50 grid place-items-center bg-slate-900/40 p-4"
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
                        <input x-model="payment.ref" type="text"
                            placeholder="Optional (e.g., last 4 digits / ref no.)"
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

        <!-- Alpine component -->

        @once
            <script>
                function pos(products, categories) {
                    return {
                        products,
                        categories,
                        query: '',
                        activeCategory: 'All',
                        inStockOnly: true,
                        sortBy: 'featured',
                        grid: 4,

                        cart: [],
                        discount: 0,
                        taxRate: 0,

                        customer: {
                            name: '',
                            phone: ''
                        },

                        variantModal: false,
                        selectedProduct: null,
                        selectedSize: 'OS',
                        selectedColor: 'Default',

                        checkoutModal: false,
                        payment: {
                            method: 'Cash',
                            tendered: 0,
                            ref: ''
                        },

                        // ---- catalog list ----
                        get visibleProducts() {
                            let list = this.products.slice();

                            if (this.activeCategory !== 'All') {
                                list = list.filter(p => p.category === this.activeCategory);
                            }

                            // IMPORTANT: robust numeric stock check
                            if (this.inStockOnly) {
                                list = list.filter(p => Number(p.stock || 0) > 0);
                            }

                            const q = this.query.trim().toLowerCase();
                            if (q.length) {
                                list = list.filter(p => {
                                    const variantSkus = (p.variants || []).map(v => v.sku).join(' ');
                                    const hay =
                                        `${p.name} ${p.sku} ${variantSkus} ${p.category} ${(p.colors||[]).join(' ')} ${(p.sizes||[]).join(' ')}`
                                        .toLowerCase();
                                    return hay.includes(q);
                                });
                            }

                            if (this.sortBy === 'price_asc') list.sort((a, b) => a.price - b.price);
                            if (this.sortBy === 'price_desc') list.sort((a, b) => b.price - a.price);
                            if (this.sortBy === 'name_asc') list.sort((a, b) => a.name.localeCompare(b.name));

                            return list;
                        },

                        filteredCount(cat) {
                            let list = this.products;

                            if (cat !== 'All') list = list.filter(p => p.category === cat);
                            if (this.inStockOnly) list = list.filter(p => Number(p.stock || 0) > 0);

                            const q = this.query.trim().toLowerCase();
                            if (q.length) {
                                list = list.filter(p => (`${p.name} ${p.sku} ${p.category}`.toLowerCase()).includes(q));
                            }
                            return list.length;
                        },

                        money(v) {
                            const n = Number(v || 0);
                            return new Intl.NumberFormat('en-PH', {
                                style: 'currency',
                                currency: 'PHP'
                            }).format(n);
                        },

                        get cartCount() {
                            return this.cart.reduce((sum, i) => sum + i.qty, 0);
                        },

                        // ---- variant helpers ----
                        currentVariant() {
                            const p = this.selectedProduct;
                            if (!p?.variants) return null;
                            return p.variants.find(v => v.size === this.selectedSize && v.color === this.selectedColor) ?? null;
                        },

                        variantStock() {
                            return Number(this.currentVariant()?.stock || 0);
                        },

                        sizeHasStock(size) {
                            const p = this.selectedProduct;
                            if (!p?.variants) return false;

                            // If a color is selected, check that exact pair; otherwise any color with stock
                            if (this.selectedColor && this.selectedColor !== 'Default') {
                                const v = p.variants.find(v => v.size === size && v.color === this.selectedColor);
                                return Number(v?.stock || 0) > 0;
                            }

                            return p.variants.some(v => v.size === size && Number(v.stock || 0) > 0);
                        },

                        colorHasStock(color) {
                            const p = this.selectedProduct;
                            if (!p?.variants) return false;

                            // If a size is selected, check that exact pair; otherwise any size with stock
                            if (this.selectedSize && this.selectedSize !== 'OS') {
                                const v = p.variants.find(v => v.color === color && v.size === this.selectedSize);
                                return Number(v?.stock || 0) > 0;
                            }

                            return p.variants.some(v => v.color === color && Number(v.stock || 0) > 0);
                        },

                        pickSize(size) {
                            this.selectedSize = size;

                            // If the exact combo is out of stock, snap to first in-stock variant of this size
                            if (this.variantStock() <= 0) {
                                const p = this.selectedProduct;
                                const match = (p?.variants || []).find(v => v.size === size && Number(v.stock || 0) > 0);
                                if (match) this.selectedColor = match.color;
                            }
                        },

                        pickColor(color) {
                            this.selectedColor = color;

                            // If the exact combo is out of stock, snap to first in-stock variant of this color
                            if (this.variantStock() <= 0) {
                                const p = this.selectedProduct;
                                const match = (p?.variants || []).find(v => v.color === color && Number(v.stock || 0) > 0);
                                if (match) this.selectedSize = match.size;
                            }
                        },

                        // ---- actions ----
                        openVariant(p) {
                            // allow opening even if out of stock (so you can view variants), but keep add disabled
                            this.selectedProduct = p;

                            const first = (p.variants || []).find(v => Number(v.stock || 0) > 0) || (p.variants || [])[0];
                            this.selectedSize = first?.size || 'OS';
                            this.selectedColor = first?.color || 'Default';

                            this.variantModal = true;
                        },

                        confirmAdd() {
                            const p = this.selectedProduct;
                            const v = this.currentVariant();
                            if (!p || !v || this.variantStock() <= 0) return;

                            const key = `${p.id}::${v.sku}`;
                            const existing = this.cart.find(i => i.key === key);

                            if (existing) existing.qty += 1;
                            else {
                                this.cart.unshift({
                                    key,
                                    id: p.id,
                                    name: p.name,
                                    sku: v.sku,
                                    image: p.image,
                                    price: p.price,
                                    size: v.size,
                                    color: v.color,
                                    qty: 1,
                                    note: '',
                                });
                            }

                            this.variantModal = false;
                        },

                        inc(key) {
                            const it = this.cart.find(i => i.key === key);
                            if (it) it.qty += 1;
                        },
                        dec(key) {
                            const it = this.cart.find(i => i.key === key);
                            if (it) it.qty = Math.max(1, it.qty - 1);
                        },
                        removeItem(key) {
                            this.cart = this.cart.filter(i => i.key !== key);
                        },

                        clearCart() {
                            this.cart = [];
                            this.discount = 0;
                            this.taxRate = 0;
                        },

                        subtotal() {
                            return this.cart.reduce((sum, i) => sum + (i.qty * i.price), 0);
                        },
                        discountApplied() {
                            return Math.min(Math.max(Number(this.discount || 0), 0), this.subtotal());
                        },
                        taxAmount() {
                            const rate = Math.max(Number(this.taxRate || 0), 0) / 100;
                            const base = Math.max(this.subtotal() - this.discountApplied(), 0);
                            return base * rate;
                        },
                        total() {
                            return Math.max(this.subtotal() - this.discountApplied(), 0) + this.taxAmount();
                        },

                        openCheckout() {
                            this.payment.tendered = this.total();
                            this.checkoutModal = true;
                        },
                        change() {
                            return Number(this.payment.tendered || 0) - this.total();
                        },

                        newSale() {
                            this.clearCart();
                            this.customer = {
                                name: '',
                                phone: ''
                            };
                            this.query = '';
                            this.activeCategory = 'All';
                        },

                        holdSale() {
                            alert('Sale held (demo). Hook this to your backend to save a held ticket.');
                        },

                        completeSale() {
                            const payload = {
                                customer: this.customer,
                                items: this.cart,
                                discount: this.discountApplied(),
                                taxRate: this.taxRate,
                                totals: {
                                    subtotal: this.subtotal(),
                                    tax: this.taxAmount(),
                                    total: this.total()
                                },
                                payment: this.payment,
                            };

                            console.log('Complete sale payload:', payload);
                            alert('Sale completed (demo). Check console for payload.');

                            this.checkoutModal = false;
                            this.newSale();
                        },
                    }
                }
            </script>
        @endonce

    </div>
@endsection
