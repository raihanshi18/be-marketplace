<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductType::all();
        return response([
            "message" => "Product Type List",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ], [
            'type_name.required' => 'Please enter product type name',
            'type_name.unique' => 'Product type name already exists',
        ]);

        ProductType::create([
            'type_name' => $request->type_name
        ]);

        return response(["message" => "Product Type Created Success"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProductType::find($id);

        if (is_null($data)) {
            return response([
                "message" => "Product Type Not Found",
                "data" => [],
            ], 404);
        }
        return response([
            "message" => "Product Type Detail",
            "data" => $data
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ]);

        $data = ProductType::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Product Type Not Found",
                "data" => [],
            ], 404);
        }

        $data->type_name = $request->type_name;
        $data->save();

        return response(["message" => "Product Type Updated Success"], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductType::find($id);

        if (is_null($data)) {
            return response([
                "message" => "Product Type Not Found",
                "data" => [],
            ], 404);
        }
        
        $data->delete();

        return response([
            "message" => "Product Type Deleted",
            "data" => $data
        ]);
    }
}
