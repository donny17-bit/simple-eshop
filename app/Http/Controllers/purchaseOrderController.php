<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class purchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase = PurchaseOrder::latest()->paginate(10);
        return [
            "status" => 'Success get purchase order',
            "data" => $purchase
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Id_Product' => 'required',
            'Invoice_Number' => 'required',
            'Quantity' => 'required',
            'Unit_Price' => 'required',
        ]);
        $stock = Product::where('id', $request->Id_Product)->get('stock')[0]->stock;
        // Log::alert($stock + $request->Quantity);
        Product::where('id', $request->Id_Product)->update(['stock' => $stock + $request->Quantity]);
        $purchase = PurchaseOrder::create([
            'id_product' => $request->Id_Product,
            'invoice_number' => $request->Invoice_Number,
            'quantity' => $request->Quantity,
            'unit_price' => $request->Unit_Price,
        ]);
        return [
            "status" => "Success add stock product",
            "data" => $purchase
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        log::alert($id);
        // return [
        //     "status" => 'Success get product',
        //     "data" => $product
        // ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
