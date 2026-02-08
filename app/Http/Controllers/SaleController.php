<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['product', 'customer'])->paginate(10);

        return view('sales.index', compact('sales'));        
    }

    public function createSale(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ]);

        Sale::create($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function updateSale(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ]);

        $sale->update($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function deleteSale($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
