<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Validator;

class ProductController extends BaseController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
         $products = Product::all();
         return $this->sendResponse($products->toArray(),'Product retrieved success'); 
     }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request){
         $input = $request->all();
         $validator = Validator::make($input,[
            'name' => 'required',
            'detail' => 'required',
            'price' => 'reuired'
         ]);
         
         if($validator->fails()){
             return $this->sendError('Validation error', $validator->errors());
         }
         $product = Product::create($input);
         return $this->sendResponse($product->toArray(),'product create success');

     }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function show($id){
         $product = Product::find($id);
         if(is_null($product)){
             return $this->sendError('product not found');
         }

         return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
     }

     
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, Product $product){
         $input = $request->all();
         $validator = Validator::make($input,[
            'name' => 'required',
            'detail' => 'required',
            'price' => 'reuired'
         ]);

        if($validator->fails()){
            return $this->sendError('Validation error', $validator->errors());
        }

        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->price = $input['price'];
        $product->save();

        return $this->sendResponse($product->toArray(), 'Product update successfully.');
     }

             
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     public function destroy(Product $product){
        $product->delete();
        return $this->sendResponse($product->toArray(),'product deleted sucsess');
     }

}