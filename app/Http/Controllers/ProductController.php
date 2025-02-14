<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // function __construct()
    // {
    //     $this->middleware('auth:sanctum', ["except" => ["index"]]);
    // }
    
    public function index()
    {
        $data = Product::join('product_types', 'products.products_type_id', '=', 'product_types.id')
            ->select('products.*', 'product_types.type_name')
            ->get();
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
            'products_name' => 'required|unique:products,products_name',
            'products_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $imageName = time() . '.' . $request->img_url->extension();
        $request->img_url->move(public_path('images'), $imageName); 

        Product::create([
            'products_name' => $request->products_name,
            'products_type_id' => $request->products_type_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_url' => url('/images/' . $imageName),
            'img_name' => $imageName
        ]);

        return response(["message" => "Product Created Success"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);

        if (is_null($data)) {
            return response([
                "message" => "Product Not Found",
                "data" => [],
            ], 404);
        }
        return response([
            "message" => "Product Detail",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'products_name' => 'required|unique:products,products_name',
            'products_type_id' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $data = Product::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Product Not Found",
                "data" => [],
            ], 404);
        }

        $imageName = time() . '.' . $request->img_url->extension();
        $request->img_url->move(public_path('images'), $imageName);

        $data->products_name = $request->products_name;
        $data->products_type_id = $request->products_type_id;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->img_url = $request->img_url;
        $data->img_name = $imageName;
        $data->save();

        return response(["message" => "Product Type Updated Success"], 201);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);

        if (is_null($data)) {
            return response([
                "message" => "Product Not Found",
                "data" => [],
            ], 404);
        }
        
        $data->delete();

        return response([
            "message" => "Product Deleted",
            "data" => $data
        ]);
    }
}
