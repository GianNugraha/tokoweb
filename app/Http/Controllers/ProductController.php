<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $Products = Product::all();
        $Products = Product::join('category_products', 'products.product_category_id', '=', 'category_products.id')
               ->get(['products.*', 'category_products.name as category_name']);
        return response()->json([
            'status' => 'success',
            'Products' => $Products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);


        if($request->hasFile('image')){
            $destination_path = 'public';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);
            $input['image'] = $image_name;
        }


        $Products = Product::create([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'image' => $image_name
        ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'Products' => $Products,
            ]);

    }

    public function show($id)
    {
        // $Products = Product::find($id);
        $Products = Product::join('category_products', 'products.product_category_id', '=', 'category_products.id')
               ->get(['products.*', 'category_products.name as category_name'])->find($id);
        return response()->json([
            'status' => 'success',
            'Products' => $Products,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_category_id' => 'integer',
            'name' => 'string|max:255',
            'price' => 'integer',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        if (!empty($request->hasFile('image'))) {
            $destination_path = 'public';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path,$image_name);
            $input['image'] = $image_name;
        }

        if (!empty($request->hasFile('image'))) {
            $Products->image = $request->file('image')->getClientOriginalName();
        }

        $Products = Product::find($id);
        if($Products === null){
            return response()->json([
                'status'    => 'error',
                'message'   => 'Invalid Product'
            ]);
        }
        else{
            // print_r($request->all());
            $Products->update($request->all());
            return $Products;

            return response()->json([
                'status' => 'success',
                'message' => 'Category Product updated successfully',
                'Products' => $Products,
            ]);
        }
    }

    public function destroy($id)
    {
        $Products = Product::find($id);
        $Products->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category Product deleted successfully',
            'Products' => $Products,
        ]);
    }
}
