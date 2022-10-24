<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'success',
            'data' => Product::paginate(8),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|integer',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }

        $product = new Product();
        $product->id = $request->id;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        
        try{
            $product->save();
            return response()->json([
                'message' => 'Success',
                'data' => $product
            ], 201);
        } catch(QueryException $e){
            return response()->json([
                'message' => $e->errorInfo,
                'data' => null
            ], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'data' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'string',
            'category_id' => 'integer',
            'price' => 'integer',
            'stock' => 'integer'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;

        try{
            $product->update();
            return response()->json([
                'messgae' => 'success',
                'data' => $product
            ], 200);
        } catch (QueryException $e){
            return response()->json([
                'message' => $e->errorInfo
            ], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Deleted',
            'success' => true
        ], 200);
    }
}
