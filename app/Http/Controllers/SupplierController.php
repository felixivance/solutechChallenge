<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('name','desc')->get();

        return api_response(true, null, 'success',
            'successfully fetched suppliers', $suppliers);
    }



    public function store(Request $request)
    {
        try{
            $supplier = new Supplier();
            $supplier->name = $request['name'];
            $supplier->save();

            return api_response(true, null, 'success',
                'successfully added supplier information', $supplier);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error adding supplier information', null);
        }
    }


    public function show($id)
    {
        try{
            $supplier = Supplier::find($id);

            return api_response(true, null, 'success',
                'successfully fetched supplier details', $supplier);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error fetching supplier detail information', null);
        }
    }


    public function update(Request $request, $id)
    {

        try{
            $supplier = Supplier::find($id);
            $supplier->name = $request['name'];
            $supplier->save();

            return api_response(true, null, 'success',
                'successfully updated supplier detail information', $supplier);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error updating order detail information', null);
        }
    }


    public function destroy($id)
    {
        try{
            $supplier = Supplier::find($id);
            $supplier->delete();

            return api_response(true, null, 'success',
                'successfully deleted supplier information', null);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error deleting supplier information', null);
        }
    }
}
