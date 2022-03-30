<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderEvent;
use PDF;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Exception;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // $orders = Order::all();
        $orders = Order::orderByDesc('id')->get();
        return view('backend.pages.order.ordermanage', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)
                ->where('is_publish', 1)
                ->get();
        
        $colors = Variant::where([ ['is_active', 1], ['variant_type', 'color']])->get();
        $sizes  = Variant::where([ ['is_active', 1], ['variant_type', 'size']])->get();

        // dd($sizes);

        return view('backend.pages.order.orderadd', compact('customers', 'products','colors','sizes'));
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

            $req = $request->all();
            if(!isset($req['order_no'])) $req['order_no'] = uniqid();

            if(!isset($req['order_date']))
                throw new Exception("Please select order date!", 403);

            if(!isset($req['customer_id']))
                throw new Exception("Please select customer!", 403);

            if(!count($req['products']))
                throw new Exception("Please select Product!", 403);

            $orderData = $request->except('products');
            $products  = $request->products;
                
            DB::beginTransaction();


            foreach ($products as $key => $product) {
                $singleProduct = Product::find($product['product_id']);
                
                $updateproduct = $singleProduct->update([
                    'total_stock_qty'       => $singleProduct->total_stock_qty - (int)$product['product_qty'],
                    'total_stock_price'     => $singleProduct->total_stock_price - (floatval($product['product_price']) * (int)$product['product_qty']),
                    'total_stock_out_qty'   => $singleProduct->total_stock_out_qty + (int)$product['product_qty'],
                    'total_stock_out_price' => $singleProduct->total_stock_out_price + (floatval($product['product_price']) * (int)$product['product_qty']),
                ]);
                
                if(!$updateproduct)
                    throw new Exception("Unable to Update Stock Qty!", 403);
                
                // if($singleProduct->is_product_variant){
                //     $variantStocks = ProductVariantPrice::where('product_id', $product['product_id'])
                //     ->where('color_name', $product['product_color'] ?? null)
                //     ->where('size_name', $product['product_size'] ?? null)
                //     ->get();
                
                //     foreach ($variantStocks as $variantStock) {
                //         ProductVariantPrice::find($variantStock->id)
                //         ->update([
                //             'stock_qty'     => $variantStock->stock_qty - (int)$product['product_qty'],
                //             'stock_out_qty' => $variantStock->stock_out_qty + (int)$product['product_qty'],
                //         ]);
                //     }
                // }
            }


            $order = Order::create($orderData);
            if(!$order)
                throw new Exception("Unable to place order!", 403);

            // $order->orderDetails()->delete();
            $order->orderDetails()->createMany($products);

            $customer = $this->getCustomer($req['customer_id']);
            $summary = $this->getOrderSummary($order->id);

            $order->update([
                'customer_name'     => $customer ? $customer->customer_name : null,
                'customer_phone'    => $customer ? $customer->customer_phone : null,
                'order_sizes'       => $summary ? $summary->order_sizes : null,
                'order_colors'      => $summary ? $summary->order_colors : null,
                'order_total_qty'   => $summary ? $summary->order_total_qty : null,
                'order_total_price' => $summary ? $summary->order_total_price : null,
            ]);
            

            DB::commit();

           return response()->json([
                'success'   => true,
                'msg'       => 'Order Created Successfully!'
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }

    }

    private function getCustomer($id=null){
        return Customer::find($id);
    }

    private function getOrderSummary($id=null){
        return OrderDetails::selectRaw('
        group_concat(product_color) order_colors,
        group_concat(product_size) order_sizes,
        sum(product_qty) order_total_qty,
        sum(subtotal) order_total_price
        ')->where('order_id',$id)
        ->groupBy('order_id')
        ->first();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, Notification $notification)
    {
        try{

            $this->markAsRead($notification);

            // dd($order);

            $pdf = PDF::loadView('backend.pages.order.show_order', compact('order'), [], [
                    'margin_left'   => 20,
                    'margin_right'  => 15,
                    'margin_top'    => 48,
                    'margin_bottom' => 25,
                    'margin_header' => 10,
                    'margin_footer' => 10,
                    'watermark'     => $this->setWaterMark($order),
                ]);


            // dd($pdf);

            return $pdf->stream('order_invoice_' . preg_replace("/\s/", '_', ($order->customer_name ?? '')) . '_' . ($order->order_date ?? '') . '_.pdf');
        }catch(Exception $e){
            dd($e->getMessage());
        }


        // return view('backend.pages.order.show_order', compact('order'));

    }



    private function setWaterMark($order)
    {
        return $order && $order->status ? ucfirst($order->status) : '';
    }


    private function markAsRead($notification)
    {
        if (!is_null($notification) && isset($notification->id)) {
            $notification->update(['read_at' => Carbon::now()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */


    public function edit(Order $order)
    {

        $customers = Customer::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)
                    ->where('is_publish', 1)
                    ->get();

        $colors = Variant::where([ ['is_active', 1], ['variant_type', 'color']])->get();
        $sizes  = Variant::where([ ['is_active', 1], ['variant_type', 'size']])->get();

        return view('backend.pages.order.orderedit', compact('customers', 'order','products','colors','sizes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        try {

            $req = $request->all();
            if(!isset($req['order_no'])) $req['order_no'] = uniqid();

            if(!isset($req['order_date']))
                throw new Exception("Please select order date!", 403);

            if(!isset($req['customer_id']))
                throw new Exception("Please select customer!", 403);

            if(!count($req['products']))
                throw new Exception("Please select Product!", 403);

            $orderData = $request->except('products');
            $products  = $request->products;

            // dd($products);
                
            DB::beginTransaction();


            foreach ($order->orderDetails as $key => $orderDetail) {

                $singleProduct = $orderDetail->product;

                $updateproduct = $singleProduct->update([
                    'total_stock_qty'       => $singleProduct->total_stock_qty + (int)$orderDetail['product_qty'],
                    'total_stock_price'     => $singleProduct->total_stock_price + (floatval($orderDetail['product_price']) * (int)$orderDetail['product_qty']),
                    'total_stock_out_qty'   => $singleProduct->total_stock_out_qty - (int)$orderDetail['product_qty'],
                    'total_stock_out_price' => $singleProduct->total_stock_out_price - (floatval($orderDetail['product_price']) * (int)$orderDetail['product_qty']),
                ]);

                if (!$updateproduct)
                    throw new Exception("Unable to Update Stock Qty!", 403);
            }


            foreach ($products as $key => $product) {

                $singleProduct = Product::find($product['product_id']);

                if($singleProduct){

                    $updateproduct = $singleProduct->update([
                        'total_stock_qty'       => $singleProduct->total_stock_qty - (int)$product['product_qty'],
                        'total_stock_price'     => $singleProduct->total_stock_price - (floatval($product['product_price']) * (int)$product['product_qty']),
                        'total_stock_out_qty'   => $singleProduct->total_stock_out_qty + (int)$product['product_qty'],
                        'total_stock_out_price' => $singleProduct->total_stock_out_price + (floatval($product['product_price']) * (int)$product['product_qty']),
                    ]);
    
                    if (!$updateproduct)
                        throw new Exception("Unable to Update Stock Qty!", 403);
                }


                
            }

            $updateOrder = $order->update($orderData);
            if(!$updateOrder)
                throw new Exception("Unable to update order!", 403);

            $order->orderDetails()->delete();
            $order->orderDetails()->createMany($products);

            $customer = $this->getCustomer($req['customer_id']);
            $summary  = $this->getOrderSummary($order->id);

            $order->update([
                'customer_name'     => $customer ? $customer->customer_name : null,
                'customer_phone'    => $customer ? $customer->customer_phone : null,
                'order_sizes'       => $summary ? $summary->order_sizes : null,
                'order_colors'      => $summary ? $summary->order_colors : null,
                'order_total_qty'   => $summary ? $summary->order_total_qty : null,
                'order_total_price' => $summary ? $summary->order_total_price : null,
            ]);

            DB::commit();

           return response()->json([
                'success'   => true,
                'msg'       => 'Order Update Successfully!'
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }

    }


    public function approval(Request $request, Order $order){

        try{
            //

            if(!$request->status) 
                throw new Exception("Please Select Status!", 403);
                
            $order->update([
                'status' => $request->status
            ]);

            if($request->status == "cancelled"){

                $products  = $order->orderDetails;

                foreach ($products as $key => $product) {

                    $singleProduct = Product::find($product['product_id']);
                    
                    if($singleProduct){

                        $updateproduct = $singleProduct->update([
                            'total_stock_qty'       => ($singleProduct->total_stock_qty + (int)$product['product_qty']),
                            'total_stock_price'     => ($singleProduct->total_stock_price) + (floatval($product['product_price']) * (int)$product['product_qty']),
                            'total_stock_out_qty'   => ($singleProduct->total_stock_out_qty) - (int)$product['product_qty'],
                            'total_stock_out_price' => ($singleProduct->total_stock_out_price) - (floatval($product['product_price']) * (int)$product['product_qty']),
                        ]);
    
                        if (!$updateproduct)
                            throw new Exception("Unable to Update Stock Qty!", 403);
                    }

                }
            }

            return response()->json([
                'success'   => true,
                'msg'       => 'Order status updated Successfully!'
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {

            $products  = $order->orderDetails;

            foreach ($products as $key => $product) {

                $singleProduct = Product::find($product['product_id']);

                if ($singleProduct) {

                    $updateproduct = $singleProduct->update([
                        'total_stock_qty'       => ($singleProduct->total_stock_qty + (int)$product['product_qty']),
                        'total_stock_price'     => ($singleProduct->total_stock_price) + (floatval($product['product_price']) * (int)$product['product_qty']),
                        'total_stock_out_qty'   => ($singleProduct->total_stock_out_qty) - (int)$product['product_qty'],
                        'total_stock_out_price' => ($singleProduct->total_stock_out_price) - (floatval($product['product_price']) * (int)$product['product_qty']),
                    ]);

                    if (!$updateproduct)
                        throw new Exception("Unable to Update Stock Qty!", 403);
                }
            }


            $isDeleted = $order->delete();
            if (!$isDeleted)
                throw new Exception("Unable to delete Order!", 403);


            $order->orderDetails()->delete();

                
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
