<?php

namespace App\Http\Controllers;

use App\Models\SupplierProduct;
use Illuminate\Http\Request;

class SupplierProductController extends Controller
{
    public function index()
    {
        $suppliers = SupplierProduct::orderBy('supply_id','desc')
            ->with(['supplier','product'])->get();

        return api_response(true, null, 'success',
            'successfully fetched suppliers', $suppliers);
    }



    public function store(Request $request)
    {
        try{
            $supplierProduct = new SupplierProduct();
            $supplierProduct->supply_id = $request['supply_id'];
            $supplierProduct->product_id = $request['product_id'];
            $supplierProduct->save();

            return api_response(true, null, 'success',
                'successfully added supplier information', $supplierProduct);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error adding supplier information', null);
        }
    }


    public function show($id)
    {
        try{
            $supplierProduct = SupplierProduct::find($id);

            return api_response(true, null, 'success',
                'successfully fetched supplier details', $supplierProduct);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error fetching supplier detail information', null);
        }
    }


    public function update(Request $request, $id)
    {

        try{
            $supplierProduct = SupplierProduct::find($id);
            $supplierProduct->supply_id = $request['supply_id'];
            $supplierProduct->product_id = $request['product_id'];
            $supplierProduct->save();

            return api_response(true, null, 'success',
                'successfully updated supplier detail information', $supplierProduct);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error updating order detail information', null);
        }
    }


    public function destroy($id)
    {
        try{
            $supplierProduct = SupplierProduct::find($id);
            $supplierProduct->delete();

            return api_response(true, null, 'success',
                'successfully deleted supplier information', null);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error deleting supplier information', null);
        }
    }
}
