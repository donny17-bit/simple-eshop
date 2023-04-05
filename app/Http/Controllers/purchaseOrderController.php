<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\User;
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
            "code" => 200,
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
        try {
            $request->validate([
                'Id_Product' => 'required',
                'Invoice_Number' => 'required',
                'Quantity' => 'required',
                'Unit_Price' => 'required',
            ]);

            $product = Product::where('id', $request->Id_Product)->get();
            if (count($product) == 0) {
                return [
                    "code" => 404,
                    "status" => "Product doesn't exist",
                    "data" => null
                ];
            }

            $stock = Product::where('id', $request->Id_Product)->get('stock')[0]->stock;
            Product::where('id', $request->Id_Product)->update(['stock' => $stock + $request->Quantity]);
            $purchase = PurchaseOrder::create([
                'id_product' => $request->Id_Product,
                'invoice_number' => $request->Invoice_Number,
                'quantity' => $request->Quantity,
                'unit_price' => $request->Unit_Price,
            ]);
            return [
                "code" => 200,
                "status" => "Success add stock product",
                "data" => $purchase
            ];
        } catch (\Throwable $th) {
            return [
                "code" => 500,
                "status" => "Failed to make request",
                "data" => null
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        try {
            $user = User::where('id', $id)->get('role')[0]->role;

            if ($user == 'user') {
                return [
                    "code" => 405,
                    "status" => "Only admin allowed",
                    "data" => null
                ];
            }

            $request->validate([
                'Id_Product' => 'required',
                'Invoice_Number' => 'required',
                'Quantity' => 'required',
                'Unit_Price' => 'required',
            ]);

            $stock = Product::where('id', $request->Id_Product)->get('stock')[0]->stock;

            Product::where('id', $request->Id_Product)->update(['stock' => $stock + $request->Quantity]);
            $purchase = PurchaseOrder::create([
                'id_product' => $request->Id_Product,
                'invoice_number' => $request->Invoice_Number,
                'quantity' => $request->Quantity,
                'unit_price' => $request->Unit_Price,
            ]);

            return [
                'code' => 200,
                "status" => "Success add stock product",
                "data" => $purchase
            ];
        } catch (\Throwable $th) {
            return [
                'code' => 500,
                "status" => "Failed to make reques",
                "data" => null
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
