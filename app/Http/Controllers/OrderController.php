<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        //get all patients
        $order = Order::orderBy('order_number','desc')->get();

        return api_response(true, null, 'success',
            'successfully fetched orders', $order);
    }



    public function store(Request $request)
    {

        try{
            $patient = new Order();
            $patient->order_number = $request['order_number'];

            $patient->save();

            return api_response(true, null, 'success',
                'successfully added patient information', $patient);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error adding patient information', null);
        }
    }


    public function show($id)
    {
        try{

            $order = Order::find($id);

            return api_response(true, null, 'success',
                'successfully fetched  order', $order);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error fetching order information', null);
        }
    }


    public function update(Request $request, $id)
    {

        try{

            $order = Order::find($id);
            $order->order_number = $request['order_number'];

            $order->save();

            return api_response(true, null, 'success',
                'successfully updated order information', $order);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error updating order information', null);
        }
    }


    public function destroy($id)
    {
        try{
            $order = Order::find($id);
            $order->delete();

            return api_response(true, null, 'success',
                'successfully deleted order information', null);

        }catch (\Exception $ex){
            return api_response(false, $ex->getMessage(), 'error',
                'error deleting order information', null);
        }
    }

}
