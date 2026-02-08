<x-dashboard-layout title="Categories">
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
                    <p class="text-sm text-gray-600">Manage your product categories.</p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Export
                    </button>

                    {{-- <a href="{{ route('categories.create') }}" --}}
                    <a href="#"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                        Add Category
                    </a>
                </div>
            </div>

            {{-- KPI Cards (optional) --}}
            @php
                $kpis = [
                    [
                        'label' => 'Total Categories',
                        'value' => $category->count(),
                        'sub' => 'Active in list',
                        'badge' => 'live',
                    ],
                    [
                        'label' => 'Placeholder KPI',
                        'value' => '—',
                        'sub' => 'Add real metric later',
                        'badge' => 'placeholder',
                    ],
                    [
                        'label' => 'Placeholder KPI',
                        'value' => '—',
                        'sub' => 'Add real metric later',
                        'badge' => 'placeholder',
                    ],
                    [
                        'label' => 'Placeholder KPI',
                        'value' => '—',
                        'sub' => 'Add real metric later',
                        'badge' => 'placeholder',
                    ],
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

                        <div class="mt-4 h-2 w-full rounded bg-gray-100">
                            <div class="h-2 w-1/2 rounded bg-indigo-200"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Main Content --}}
            <div class="mt-8 grid grid-cols-1 gap-6">

                {{-- Categories Table Card --}}
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">All Categories</h2>
                            <p class="text-xs text-gray-500">Search, sort, and paginate using DataTables.</p>
                        </div>
                        <span
                            class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                            table
                        </span>
                    </div>

                    @if ($category->count())
                        <div class="mt-4 overflow-hidden rounded-lg border border-gray-200">
                            <table id="categoriesTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Category
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($category as $cat)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                {{ $cat->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div
                            class="mt-4 rounded-md border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-600">
                            No active category found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery + DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#categoriesTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [0, 'asc']
                ],
                dom: '<"px-4 py-3 bg-white flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"lf>rt<"px-4 py-3 bg-white flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"ip><"clear">',
            });
        });
    </script>

    {{-- Optional: make DataTables controls look closer to Tailwind --}}
    <style>
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.4rem 0.6rem;
            margin-left: 0.5rem;
            background: #fff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            border: 1px solid #e5e7eb !important;
            background: #fff !important;
            margin: 0 2px;
            padding: 0.25rem 0.6rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #eef2ff !important;
            border-color: #c7d2fe !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0;
        }
    </style>
</x-dashboard-layout>
