<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PosController extends Controller
{
    public function index()
    {
        $rows = Product::query()
            ->active()
            ->with('category:id,name')
            ->with(['variants:id,product_id,size,color,sku,current_stock'])
            ->withSum('variants as stock', 'current_stock')
            ->get();

        $products = $rows->map(function ($p) {
            return [
                'id'       => $p->id,
                'name'     => $p->name,
                'sku'      => $p->variants->first()->sku ?? ('PRD-'.$p->id),
                'category' => $p->category->name ?? 'Uncategorized',
                'price'    => (float) $p->base_price,
                'stock'    => (int) ($p->stock ?? 0),

                // IMPORTANT: plain arrays for JS
                'sizes'  => $p->variants->pluck('size')->unique()->values()->all(),
                'colors' => $p->variants->pluck('color')->unique()->values()->all(),

                'image' => 'https://placehold.co/600x400/EEE/31343C',

                // IMPORTANT: plain arrays for JS
                'variants' => $p->variants->map(fn ($v) => [
                    'id'    => $v->id,
                    'size'  => $v->size,
                    'color' => $v->color,
                    'sku'   => $v->sku,
                    'stock' => (int) $v->current_stock,
                ])->values()->all(),
            ];
        })->values()->all();

        $categories = collect($products)->pluck('category')->unique()->values()->all();

        return view('pos.index', compact('products', 'categories'));
    }
}
