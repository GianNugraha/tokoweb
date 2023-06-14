<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;

class CategoryProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $CategoryProducts = CategoryProduct::all();
        return response()->json([
            'status' => 'success',
            'CategoryProducts' => $CategoryProducts,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $CategoryProducts = CategoryProduct::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category Product created successfully',
            'CategoryProducts' => $CategoryProducts,
        ]);
    }

    public function show($id)
    {
        $CategoryProducts = CategoryProduct::find($id);
        return response()->json([
            'status' => 'success',
            'CategoryProducts' => $CategoryProducts,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $CategoryProducts = CategoryProduct::find($id);
        $CategoryProducts->name = $request->name;
        $CategoryProducts->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category Product updated successfully',
            'CategoryProducts' => $CategoryProducts,
        ]);
    }

    public function destroy($id)
    {
        $CategoryProducts = CategoryProduct::find($id);
        $CategoryProducts->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category Product deleted successfully',
            'CategoryProducts' => $CategoryProducts,
        ]);
    }
}
