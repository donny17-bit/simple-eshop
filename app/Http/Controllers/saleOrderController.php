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
        $request->validate([
            'Id_Customer' => 'required',
            'Id_Product' => 'required',
            'Quantity' => 'required',
            'Unit_Price' => 'required',
        ]);

        $product = Product::where('id', $request->Id_Product)->get();
        $user = Product::where('id', $request->Id_Customer)->get();
        // if (count($product) > 0) {
        //     Log::alert(true);
        // } else {
        //     Log::alert(false);
        // }
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

        $sale = SaleOrder::create([
            'id_customer' => $request->Id_Customer,
            'id_product' => $request->Id_Product,
            'quantity' => $request->Quantity,
            'unit_price' => $request->Unit_Price,
        ]);

        return [
            "code" => 200,
            "status" => "Success add stock product",
            "data" => $sale
        ];
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
        $saleItem = SaleOrder::where('id', $id)->get();
        if (count($saleItem) < 1) {
            return [
                "code" => 404,
                "status" => "Id sale order doesn't exist",
                "data" => null
            ];
        }
        SaleOrder::where('id', $id)->update(['status' => 1]);
        $sale = SaleOrder::where('id', $id)->get();
        return [
            "code" => 200,
            "status" => "Approve success",
            "data" => $sale
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
