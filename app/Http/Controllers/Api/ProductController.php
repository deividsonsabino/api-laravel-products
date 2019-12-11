<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->all();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        $data = $request->all();
        
        $this->product->create($data);

        return response()->json($data,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        if (!$product = $this->product->find($id)) {
            return response()->json(["Error" => "Product not found"],404);
        }

        return response()->json($product, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        $product = $this->product->find($id);

        if (!$product) {
            return response()->json(["Error" => "Product not found"],404);
        }

        $data = $request->all();

        $product->update($data);

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);

        if(!$product) {
            return response()->json(["Error" => "Product not found"],404);
        }

        $product->delete();

        return response()->json(["Success" => "Product deleted!"]);

    }
}
