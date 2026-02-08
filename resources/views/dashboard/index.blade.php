<x-dashboard-layout title="Dashboard">
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Inventory Dashboard</h1>
                    <p class="text-sm text-gray-600">Clothing store overview — stock, sales, and alerts (placeholder).
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Export Inventory
                    </button>
                    <button type="button"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                        Add Product
                    </button>
                </div>
            </div>

            {{-- KPI Cards --}}
            @php
                // Replace these with real values from controller later
                $kpis = [
                    [
                        'label' => 'Total SKUs',
                        'value' => '—',
                        'sub' => 'All variants (size/color)',
                        'badge' => 'placeholder',
                    ],
                    [
                        'label' => 'Items In Stock',
                        'value' => '—',
                        'sub' => 'Total quantity across SKUs',
                        'badge' => 'placeholder',
                    ],
                    [
                        'label' => 'Low Stock Alerts',
                        'value' => '—',
                        'sub' => 'Below reorder point',
                        'badge' => 'action',
                    ],
                    ['label' => 'Out of Stock', 'value' => '—', 'sub' => 'Needs restock', 'badge' => 'urgent'],
                ];
            @endphp

            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($kpis as $kpi)
                    <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">{{ $kpi['label'] }}</p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $kpi['value'] }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $kpi['sub'] }}</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                                {{ $kpi['badge'] }}
                            </span>
                        </div>

                        {{-- tiny placeholder bar --}}
                        <div class="mt-4 h-2 w-full rounded bg-gray-100">
                            <div class="h-2 w-1/2 rounded bg-indigo-200"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Main Grid --}}
            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Stock Movement / Sales Trend (Placeholder chart area) --}}
                <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-gray-900">Stock Movement & Sales Trend</h2>
                        <div class="flex gap-2">
                            <button
                                class="rounded-md bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">Today</button>
                            <button
                                class="rounded-md bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">7d</button>
                            <button
                                class="rounded-md bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-200">30d</button>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6">
                        <div class="text-center">
                            <div class="mx-auto h-12 w-12 rounded-full bg-indigo-100"></div>
                            <p class="mt-3 text-sm font-medium text-gray-700">Chart Placeholder</p>
                            <p class="text-xs text-gray-500">Use Chart.js / ApexCharts to show sales + stock
                                adjustments.</p>
                        </div>

                        {{-- Optional hook --}}
                        {{-- <canvas id="salesStockChart" class="mt-6 w-full"></canvas> --}}
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-gray-200">
                            <p class="text-xs text-gray-500">Today’s Sales</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">—</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-gray-200">
                            <p class="text-xs text-gray-500">Units Sold</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">—</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 ring-1 ring-gray-200">
                            <p class="text-xs text-gray-500">Returns</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">—</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="text-base font-semibold text-gray-900">Quick Actions</h2>

                    <div class="mt-4 space-y-3">
                        <a href="#" class="block rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">Add New Product</p>
                            <p class="text-xs text-gray-500">Create SKU + variants (size/color)</p>
                        </a>
                        <a href="#" class="block rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">Receive Stock</p>
                            <p class="text-xs text-gray-500">Increase inventory (purchase order)</p>
                        </a>
                        <a href="#" class="block rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">Stock Adjustment</p>
                            <p class="text-xs text-gray-500">Damage, shrinkage, recount</p>
                        </a>
                        <a href="#" class="block rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                            <p class="text-sm font-medium text-gray-800">Print Barcode Labels</p>
                            <p class="text-xs text-gray-500">Placeholder action</p>
                        </a>
                    </div>

                    <div
                        class="mt-6 rounded-md border border-dashed border-gray-300 bg-gray-50 p-3 text-xs text-gray-600">
                        Tip: Set reorder points per variant (e.g., Small/Black) for accurate alerts.
                    </div>
                </div>

                {{-- Low Stock Alerts --}}
                <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-gray-900">Low Stock Alerts</h2>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Manage
                            reorder points</a>
                    </div>

                    <div class="mt-4 overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Variant</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">On Hand</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Reorder Point
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @php
                                    $lowStock = [
                                        [
                                            'product' => 'Basic Tee',
                                            'variant' => 'Black / M',
                                            'on_hand' => '—',
                                            'reorder' => '—',
                                            'status' => 'Low',
                                        ],
                                        [
                                            'product' => 'Denim Jacket',
                                            'variant' => 'Blue / L',
                                            'on_hand' => '—',
                                            'reorder' => '—',
                                            'status' => 'Low',
                                        ],
                                        [
                                            'product' => 'Chino Pants',
                                            'variant' => 'Khaki / 32',
                                            'on_hand' => '—',
                                            'reorder' => '—',
                                            'status' => 'Critical',
                                        ],
                                    ];
                                @endphp

                                @foreach ($lowStock as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $row['product'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $row['variant'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $row['on_hand'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $row['reorder'] }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                                                {{ $row['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-xs text-gray-500">
                        Placeholder table — populate from variants where <code
                            class="px-1 py-0.5 bg-gray-100 rounded">qty &lt;= reorder_point</code>.
                    </div>
                </div>

                {{-- Recent Inventory Activity --}}
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="text-base font-semibold text-gray-900">Recent Inventory Activity</h2>

                    @php
                        $activity = [
                            ['title' => 'Stock received', 'meta' => 'PO #— • Supplier —', 'time' => '—'],
                            ['title' => 'Stock adjusted', 'meta' => 'Reason: Damage • SKU —', 'time' => '—'],
                            ['title' => 'Item sold', 'meta' => 'Order #— • Channel —', 'time' => '—'],
                            ['title' => 'Return processed', 'meta' => 'RMA #— • SKU —', 'time' => '—'],
                        ];
                    @endphp

                    <ul class="mt-4 space-y-3">
                        @foreach ($activity as $item)
                            <li class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                <p class="text-sm font-medium text-gray-900">{{ $item['title'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['meta'] }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ $item['time'] }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <a href="#"
                        class="mt-4 inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        View activity log
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
