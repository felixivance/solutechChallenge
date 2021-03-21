<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name','desc')->get();

        return api_response(true, null, 'success',
            'successfully fetched products', $products);
    }



    public function store(Request $request)
    {
        try{
            $product = new Product();
            $product->name = $request['name'];
            $product->description = $request['description'];
            $product->quantity = $request['quantity'];
            $product->save();

            return api_response(true, null, 'success',
                'successfully added product information', $product);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error adding product information', null);
        }
    }


    public function show($id)
    {
        try{
            $product = Product::find($id);

            return api_response(true, null, 'success',
                'successfully fetched product details', $product);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error fetching product detail information', null);
        }
    }


    public function update(Request $request, $id)
    {

        try{
            $product = Product::find($id);
            $product->name = $request['name'];
            $product->description = $request['description'];
            $product->quantity = $request['quantity'];
            $product->save();

            return api_response(true, null, 'success',
                'successfully updated product detail information', $product);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error updating order detail information', null);
        }
    }


    public function destroy($id)
    {
        try{
            $product = Product::find($id);
            $product->delete();

            return api_response(true, null, 'success',
                'successfully deleted productinformation', null);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error deleting product information', null);
        }
    }
}
