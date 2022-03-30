<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtherOrder;
use Exception;
use Illuminate\Http\Request;

class OtherOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $otherOrders = OtherOrder::orderByDesc('id')->get();
        // dd($otherOrders);
        return view('backend.pages.otherorder.otherorder', compact('otherOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $data = $request->all();

            if(!$request->order_no){
                $data['order_no'] =  uniqid();
            }

            $data['created_by'] = auth()->guard('admin')->user()->id ?? null;
            $orderorder   = OtherOrder::create($data);
            if(!$orderorder)
                throw new Exception("Unable to create Other Order!", 403);

            return response()->json([
                'success'   => true,
                'msg'       => 'Other Order Created Successfully!',
                'data'      => $orderorder
            ]);
                
        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( OtherOrder $otherOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * $data['order_no']               =  uniqid();
     */
    public function update(Request $request, OtherOrder $otherOrder)
    {
        try {

            $data = $request->all();

            $data['updated_by'] = auth()->guard('admin')->user()->id ?? null;
            $orderstatus        = $otherOrder->update($data);
            if(!$orderstatus)
                throw new Exception("Unable to Update Order!", 403);

            return response()->json([
                'success'   => true,
                'msg'       => 'Order Updated Successfully!'
            ]);
                
        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( OtherOrder $otherOrder)
    {
        try {

            $isDeleted = $otherOrder->delete();
            if(!$isDeleted)
                throw new Exception("Unable to delete Order!", 403);
                
            return response()->json([
                'success'   => true,
                'msg'       => 'Order Deleted Successfully!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage()
            ]);
        }
    }


}
