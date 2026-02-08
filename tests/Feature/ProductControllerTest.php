<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Minimal route so we can hit the controller in a test.
        Route::get('/__test/products', [ProductController::class, 'index']);
    }

    public function test_index_sends_paginated_active_products_to_view_with_relations_loaded(): void
    {
        $category = Category::factory()->create(['name' => 'Tops']);

        // Create 12 ACTIVE products so page 1 contains 10 (per paginate(10)).
        $activeProducts = collect();
        for ($i = 1; $i <= 12; $i++) {
            $p = $this->createActiveProduct([
                'name'        => "Active {$i}",
                'category_id' => $category->id,
            ]);

            // Optional: add a variant so you can see variants data in the payload.
            // If your variants table has extra NOT NULL columns, add them here.
            $p->variants()->create([
                'size'          => 'M',
                'color'         => 'Red',
                'sku'           => "SKU-{$p->id}",
                'current_stock' => 5,
            ]);

            $activeProducts->push($p->fresh());
        }

        // Create 1 INACTIVE product (should NOT show in results).
        $inactive = $this->createInactiveProduct([
            'name'        => 'Inactive',
            'category_id' => $category->id,
        ]);

        $response = $this->get('/__test/products');

        $response->assertOk();
        $response->assertViewIs('products.index');

        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        $products = $response->viewData('products');

        // ---- What the controller sends back ----
        $this->assertInstanceOf(LengthAwarePaginator::class, $products);

        // Basic pagination expectations: paginate(10)
        $this->assertSame(10, $products->perPage());
        $this->assertSame(1, $products->currentPage());
        $this->assertSame(12, $products->total());      // only active products
        $this->assertCount(10, $products->items());     // first page size

        // Ensure inactive product is NOT in the page results
        $this->assertFalse(
            collect($products->items())->contains(fn ($p) => $p->id === $inactive->id)
        );

        // Ensure eager-loaded relations are actually loaded (category, variants)
        foreach ($products->items() as $p) {
            $this->assertTrue($p->relationLoaded('category'));
            $this->assertTrue($p->relationLoaded('variants'));
        }

        // ✅ Print the payload so you can see it while running tests.
        // Use dd(...) instead of dump(...) if you want the test to stop here.
        dump([
            'paginator_meta' => [
                'total'        => $products->total(),
                'per_page'     => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
            ],
            'products_page_1' => $products->toArray(), // includes data + links/meta
        ]);
    }

    /**
     * Creates a product that definitely matches Product::active() scope
     * WITHOUT assuming your column names (status/is_active/etc).
     */
    private function createActiveProduct(array $overrides = []): Product
    {
        $product = Product::factory()->create($overrides);

        $constraints = $this->activeScopeBasicConstraints();

        if (!empty($constraints)) {
            $product->forceFill($constraints)->save();
        }

        $this->assertTrue(
            Product::query()->active()->whereKey($product->getKey())->exists(),
            'Expected product to match Product::active() scope but it did not. ' .
            'Your scopeActive() might include complex conditions (raw/nested/joins).'
        );

        return $product->refresh();
    }

    /**
     * Creates a product that does NOT match Product::active() scope.
     */
    private function createInactiveProduct(array $overrides = []): Product
    {
        $product = Product::factory()->create($overrides);

        if (Product::query()->active()->whereKey($product->getKey())->doesntExist()) {
            return $product;
        }

        $constraints = $this->activeScopeBasicConstraints();

        foreach ($constraints as $column => $value) {
            $product->forceFill([$column => $this->differentValue($value)])->save();

            if (Product::query()->active()->whereKey($product->getKey())->doesntExist()) {
                return $product->refresh();
            }

            // revert and try next column
            $product->forceFill([$column => $value])->save();
        }

        $this->fail(
            'Could not create an inactive product by flipping basic scope constraints. ' .
            'Set the inactive product attributes to a known non-active state manually.'
        );
    }

    /**
     * Extract simple "where" constraints from Product::active() (Basic '=' / Null / In).
     */
    private function activeScopeBasicConstraints(): array
    {
        $builder = Product::query()->active();
        $wheres = $builder->getQuery()->wheres ?? [];

        $out = [];

        foreach ($wheres as $where) {
            $type = $where['type'] ?? null;

            if ($type === 'Basic') {
                if (($where['operator'] ?? '=') !== '=') continue;

                $col = $this->stripTable($where['column'] ?? '');
                if ($col !== '') $out[$col] = $where['value'] ?? null;
            }

            if ($type === 'Null') {
                $col = $this->stripTable($where['column'] ?? '');
                if ($col !== '') $out[$col] = null;
            }

            if ($type === 'In') {
                $col = $this->stripTable($where['column'] ?? '');
                $vals = $where['values'] ?? [];
                if ($col !== '' && !empty($vals)) $out[$col] = $vals[0];
            }
        }

        return $out;
    }

    private function stripTable(string $column): string
    {
        return Str::contains($column, '.') ? Str::afterLast($column, '.') : $column;
    }

    private function differentValue(mixed $value): mixed
    {
        if (is_bool($value)) return !$value;
        if (is_int($value)) return $value + 1;
        if (is_float($value)) return $value + 1.0;
        if (is_string($value)) return $value . '__inactive';
        return null;
    }
}
