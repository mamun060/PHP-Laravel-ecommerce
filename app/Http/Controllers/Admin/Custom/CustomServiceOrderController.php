<?php

namespace App\Http\Controllers\Admin\Custom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomOrderRequest;
use App\Http\Services\CustomerChecker;
use App\Models\Custom\CustomServiceCategory;
use App\Models\Custom\CustomServiceOrder;
use App\Models\Custom\CustomServiceProduct;
use Exception;
use DB;
use App\Http\Services\ImageChecker;

class CustomServiceOrderController extends Controller
{
    use ImageChecker, CustomerChecker;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customserviceorders = CustomServiceOrder::orderByDesc('id')->get();
        $customservicecategories = CustomServiceCategory::get();
        $customserviceproducts = CustomServiceProduct::get();
        return view('backend.pages.custom_order.managecustomorder', compact('customserviceorders','customservicecategories','customserviceproducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getProduct($category_id)
    {
        try {

            $customproducts = CustomServiceProduct::selectRaw(
                'product_name as text, id'
            )->where('category_id', $category_id)->get();
            
            return response()->json($customproducts);

        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }


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
    public function store(CustomOrderRequest $request)
    {
        try {
            // dd($request->all());

            $order_attachment   = $request->order_attachment;
            $data               = $request->all();

            $product_id = $request->custom_service_product_id;
            if($product_id){
                $data['custom_service_product_name']= $this->getProductName($product_id);
            }

            $fileLocation       = null;
    
            if($order_attachment){
                //file, dir
                $fileResponse = $this->uploadFile($order_attachment, 'CustomServiceOrder/');
                if (!$fileResponse['success'])
                    throw new Exception($fileResponse['msg'], $fileResponse['code'] ?? 403);
    
                $fileLocation = $fileResponse['fileLocation'];
            }
            
            $data['order_attachment']       = $fileLocation;
            $data['order_no']               =  uniqid();
            $data['order_qty']              =  0;
            $data['order_discount_price']   =  0;
            $data['order_total_price']      =  0;
            $data['advance_balance']        =  0;
            $data['status']                 =  'pending';

            DB::beginTransaction();
            $oldcustomer = $this->isCustomerExists($data['customer_name'], $data['customer_phone']);
            if($oldcustomer['success']){
                $data['customer_id'] = $oldcustomer['data']->id;
            }else{

                $customer = $this->createCustomer([
                    'customer_name'     => $data['customer_name'],
                    'customer_phone'    => $data['customer_phone'],
                    'customer_address'  => $data['customer_address'],
                    'current_balance'   => 0,
                    'is_active'         => 1,
                ]);

                if(!$customer['success']) 
                    throw new Exception($customer['msg'], 403);

                $data['customer_id'] = $customer['data']->id;

                $customerType = $this->createCustomerType([
                    'customer_id' => $data['customer_id'],
                    'customer_type' => 'customize',
                ]);
                
                if(!$customerType['success']) 
                    throw new Exception($customerType['msg'], 403);

            }

            $customserviceorder = CustomServiceOrder::create($data);

            if(!$customserviceorder)
                throw new Exception('Unable to create Order', 403);

            DB::commit();

            return response()->json([
                'success'   => true,
                'msg'       => 'Order Created Successfully!',
                'data'      => $customserviceorder
            ]);

        } catch (\Exception $th) {
            DB::rollback();

            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }


    private function getProductName($id=null){
        
        $customproduct = CustomServiceProduct::selectRaw(
            'product_name, id'
        )->where('id', $id)->first();

        if($customproduct) return $customproduct->product_name;

        return null;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomServiceOrder  $customServiceOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CustomServiceOrder $customServiceOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomServiceOrder  $customServiceOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomServiceOrder $customServiceOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomServiceOrder  $customServiceOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomServiceOrder $customServiceOrder)
    {
        try {

            if(!$customServiceOrder)
                throw new Exception("No record Found!", 404);
                
            $data               = $request->all();
            $order_attachment   = $request->order_attachment;
            $fileLocation       = $customServiceOrder->order_attachment;

            $product_id = $request->custom_service_product_id;
            if($product_id){
                $data['custom_service_product_name']= $this->getProductName($product_id);
            }

            if ($order_attachment) {
                //file, dir
                if($fileLocation){
                    $this->deleteImage($fileLocation);
                }
                
                $fileResponse = $this->uploadFile($order_attachment, 'CustomServiceOrder/');
                if (!$fileResponse['success'])
                    throw new Exception($fileResponse['msg'], $fileResponse['code'] ?? 403);

                $fileLocation = $fileResponse['fileLocation'];
            }

            $data['order_attachment'] = $fileLocation;
            $data['updated_by'] = auth()->guard('admin')->user()->id ?? null;
            $customorderstatus = $customServiceOrder->update($data);
            if(!$customorderstatus)
                throw new Exception("Unable to Update Order!", 403);

            return response()->json([
                'success'   => true,
                'msg'       => 'Order Updated Successfully!',
                'data'      => $customServiceOrder->first()
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
     * @param  \App\Models\CustomServiceOrder  $customServiceOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomServiceOrder $customServiceOrder)
    {
        try {

            $isDeleted = $customServiceOrder->delete();
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
