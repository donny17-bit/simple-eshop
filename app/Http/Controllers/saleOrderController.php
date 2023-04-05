<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class saleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sale = SaleOrder::latest()->paginate(10);
        return [
            "code" => 200,
            "status" => "Success get all sale order",
            "data" => $sale
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
                'Id_Customer' => 'required',
                'Id_Product' => 'required',
                'Quantity' => 'required',
                'Unit_Price' => 'required',
            ]);


            $product = Product::where('id', $request->Id_Product)->get();
            $user = Product::where('id', $request->Id_Customer)->get();
            $invoiceNumber = $request->Invoice_Number;

            if (count($user) < 1) {
                return [
                    "code" => 404,
                    "status" => "Id customer doesn't exist",
                    "data" => null
                ];
            }
            if (count($product) < 1) {
                return [
                    "code" => 404,
                    "status" => "Id product doesn't exist",
                    "data" => null
                ];
            }

            $stock = Product::where('id', $request->Id_Product)->get('stock')[0]->stock;
            if ($invoiceNumber) {
                Product::where('id', $request->Id_Product)->update([
                    'stock' => $stock - $request->Quantity
                ]);
                $sale = SaleOrder::create([
                    'id_customer' => $request->Id_Customer,
                    'id_product' => $request->Id_Product,
                    'invoice_number' => $invoiceNumber,
                    'quantity' => $request->Quantity,
                    'unit_price' => $request->Unit_Price,
                    'status' => 1,
                ]);
            } else {
                $sale = SaleOrder::create([
                    'id_customer' => $request->Id_Customer,
                    'id_product' => $request->Id_Product,
                    'quantity' => $request->Quantity,
                    'unit_price' => $request->Unit_Price,
                ]);
            }

            return [
                "code" => 200,
                "status" => "Success add stock product",
                "data" => $sale
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
        //
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
            $saleItem = SaleOrder::where('id', $id)->get();
            $stock = Product::where('id', $saleItem[0]->id_product)->get('stock')[0]->stock;

            if (count($saleItem) < 1) {
                return [
                    "code" => 404,
                    "status" => "Id sale order doesn't exist",
                    "data" => null
                ];
            }
            SaleOrder::where('id', $id)->update([
                'status' => 1
            ]);
            Product::where('id', $saleItem[0]->id_product)->update([
                'stock' => $stock - $saleItem[0]->quantity
            ]);

            $sale = SaleOrder::where('id', $id)->get();
            return [
                "code" => 200,
                "status" => "Approve success",
                "data" => $sale
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
