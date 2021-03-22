<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetails::orderBy('order_id','desc')->with('product','order')->get();

        return api_response(true, null, 'success',
            'successfully fetched orders', $orderDetails);
    }



    public function store(Request $request)
    {

        try{
            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $request['order_id'];
            $orderDetails->product_id = $request['product_id'];

            $orderDetails->save();

            return api_response(true, null, 'success',
                'successfully added order information', $orderDetails);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error adding order information', null);
        }
    }


    public function show($id)
    {
        try{
            $orderDetail = OrderDetails::find($id);

            return api_response(true, null, 'success',
                'successfully fetched order detail', $orderDetail);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error fetching order detail information', null);
        }
    }


    public function update(Request $request, $id)
    {

        try{
            $orderDetail = OrderDetails::find($id);
            $orderDetail->order_id = $request['order_detail'];
            $orderDetail->product_id = $request['product_id'];
            $orderDetail->save();

            return api_response(true, null, 'success',
                'successfully updated order detail information', $orderDetail);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error updating order detail information', null);
        }
    }


    public function destroy($id)
    {
        try{
            $orderDetail = OrderDetails::find($id);
            $orderDetail->delete();

            return api_response(true, null, 'success',
                'successfully deleted order detail information', null);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error deleting order detail information', null);
        }
    }

}
