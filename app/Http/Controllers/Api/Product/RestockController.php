<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Restock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestockController extends Controller
{
    public function index(){
        return response()->json([
            'data' => Restock::paginate(8),
        ], 200);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            're_stock' => 'required|integer'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }

        $stock = new Restock();
        $stock->product_id = $request->product_id;
        $stock->re_stock = $request->re_stock;

        try{
            $stock->save();
            return response()->json([
                'message' => 'Success',
                'data' => $stock
            ], 201);
        } catch (QueryException $e){
            return response()->json([
                'message' => $e->errorInfo,
                'data' => null
            ], 422);
        }
    }
}
