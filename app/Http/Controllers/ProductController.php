<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::latest()->paginate(10);
        return [
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
        $request->validate([
            'sku' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product = Product::create($request->all());

        return [
            "status" => "Success post data",
            "data" => $product
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return [
            "status" => 1,
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
