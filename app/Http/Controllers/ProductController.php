<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::latest()->paginate(10);
        return [
            "code" => 200,
            "status" => "Success get product",
            "data" => $product
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return [
            "status" => 'Success get product',
            "data" => $product
        ];
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
                'sku' => 'required',
                'product_name' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);

            $product = Product::create($request->all());

            return [
                'code' => 200,
                "status" => "Success add product",
                "data" => $product
            ];
        } catch (\Throwable $th) {
            return [
                'code' => 500,
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
