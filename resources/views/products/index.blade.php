<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-4">Products Test</h1>

        @if ($products->count())
            <ul class="list-none space-y-4">
                @foreach ($products as $product)
                    <li class="p-4 bg-white rounded shadow">
                        <strong class="text-red-500">{{ $product->name }}</strong>
                        <div class="text-gray-600">Category: {{ $product->category?->name ?? 'Uncategorized' }}</div>

                        @if ($product->variants->count())
                            <div class="mt-2 font-semibold">Variants:</div>
                            <ul class="list-disc list-inside ml-4">
                                @foreach ($product->variants as $variant)
                                    <li>{{ $variant->color }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <p>No active products found.</p>
        @endif
    </div>
@endsection
