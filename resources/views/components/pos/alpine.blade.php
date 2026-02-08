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

                get visibleProducts() {
                    let list = this.products.slice();

                    if (this.activeCategory !== 'All') {
                        list = list.filter(p => p.category === this.activeCategory);
                    }

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

                    if (this.selectedColor && this.selectedColor !== 'Default') {
                        const v = p.variants.find(v => v.size === size && v.color === this.selectedColor);
                        return Number(v?.stock || 0) > 0;
                    }

                    return p.variants.some(v => v.size === size && Number(v.stock || 0) > 0);
                },

                colorHasStock(color) {
                    const p = this.selectedProduct;
                    if (!p?.variants) return false;

                    if (this.selectedSize && this.selectedSize !== 'OS') {
                        const v = p.variants.find(v => v.color === color && v.size === this.selectedSize);
                        return Number(v?.stock || 0) > 0;
                    }

                    return p.variants.some(v => v.color === color && Number(v.stock || 0) > 0);
                },

                pickSize(size) {
                    this.selectedSize = size;

                    if (this.variantStock() <= 0) {
                        const p = this.selectedProduct;
                        const match = (p?.variants || []).find(v => v.size === size && Number(v.stock || 0) > 0);
                        if (match) this.selectedColor = match.color;
                    }
                },

                pickColor(color) {
                    this.selectedColor = color;

                    if (this.variantStock() <= 0) {
                        const p = this.selectedProduct;
                        const match = (p?.variants || []).find(v => v.color === color && Number(v.stock || 0) > 0);
                        if (match) this.selectedSize = match.size;
                    }
                },

                openVariant(p) {
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
