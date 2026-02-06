<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PosController extends Controller {

public function index()
{
    $rows = Product::query()
        ->active()
        ->with('category:id,name')
        ->with(['variants:id,product_id,size,color,sku,current_stock'])
        ->withSum('variants as stock', 'current_stock') // total stock per product
        ->get();

    $products = $rows->map(function ($p) {
        return [
            'id'       => $p->id,
            'name'     => $p->name,
            'sku'      => $p->variants->first()->sku ?? ('PRD-'.$p->id), // display only
            'category' => $p->category->name ?? 'Uncategorized',
            'price'    => (float) $p->base_price,
            'stock'    => (int) ($p->stock ?? 0),
            'sizes'    => $p->variants->pluck('size')->unique()->values(),
            'colors'   => $p->variants->pluck('color')->unique()->values(),
            'image'    => 'https://placehold.co/600x400/EEE/31343C',
            'variants' => $p->variants->map(fn($v) => [
                'id'    => $v->id,
                'size'  => $v->size,
                'color' => $v->color,
                'sku'   => $v->sku,
                'stock' => (int) $v->current_stock,
            ])->values(),
        ];
    })->values();

    $categories = $products->pluck('category')->unique()->values();

    return view('pos.index', compact('products', 'categories'));
}

}
