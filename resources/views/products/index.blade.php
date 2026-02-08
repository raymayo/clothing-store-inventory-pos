<h1>Products Test</h1>

@if ($products->count())
    <ul>
        @foreach ($products as $product)
            <li>
                <strong>{{ $product->name }}</strong>
                <div>Category: {{ $product->category?->name ?? 'Uncategorized' }}</div>

                @if ($product->variants->count())
                    <div>Variants:</div>
                    <ul>
                        @foreach ($product->variants as $variant)
                            <li>{{ $variant->color }}</li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    {{ $products->links() }}
@else
    <p>No active products found.</p>
@endif
