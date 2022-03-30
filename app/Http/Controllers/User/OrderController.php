<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Events\OrderEvent;
use App\Models\ApplyCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomOrderRequest;
use App\Http\Services\CouponChecker;
use App\Models\Custom\CustomServiceOrder;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\ProductVariantPrice;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    use CouponChecker;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {

        $cartProducts = null;
        $productIds = Cookie::get('productIds');
        if (!is_null($productIds)) {
            $productIds     = unserialize($productIds);
            $uniqueProducts = array_unique($productIds);
            $cartProducts   = Product::whereIn('id', $uniqueProducts)->get();
            // dd($cartProducts);
        }

        $coupon = Coupon::where('status', 1)->get();
        // dd($coupon);
        return view('frontend.pages.checkout', compact('product', 'cartProducts','coupon'));
        //checkout
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


    public function trackOrder(Request $request)
    {
        try {

            $order_no = $request->order_no;
            if(!$order_no)
                throw new Exception("Please Input Order No!", 403);

            $order = Order::with('customer')
                    ->where('order_no', $order_no)
                    ->where('status','!=', 'cancelled')
                    ->where('status','!=', 'returned')
                    ->first();

            // dd($order);

            $customOrder = CustomServiceOrder::selectRaw('*, convert(created_at, DATE) as order_date')
                        ->where('status', '!=', 'cancelled')
                        ->where('status', '!=', 'returned')
                        ->where('order_no', $order_no)->first();

            $orderData = null;
            $order_from = null;

            if($order){
                $orderData = $order;
                $order_from = 'ecomerce';
            }else{
                $orderData = $customOrder;
                $order_from = 'customize';
            }

            return response()->json([
                'success'   => true,
                'data'      => $orderData,
                'order_from'=> $order_from
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }


    public function checkCoupon(Request $request){

        try {

            $coupon = $request->coupon;      
            $order  = $request->order;

            if(session('coupon')) 
                throw new Exception("Coupon Already applied!", 403);

            $couponResponse = $this->checkCouponValidation($coupon, $order);
            if(!$couponResponse['success'])
                throw new Exception($couponResponse['msg'], $couponResponse['code']);

            $couponData     = $couponResponse['data'] ?? null;
            $couponResponse = $this->checkCouponItemsValidation($couponData, $order);
            if(!$couponResponse['success'])
                throw new Exception($couponResponse['msg'], $couponResponse['code']);

            // dd($couponData, $couponResponse['data']); 

            session()->put('coupon',[
                'coupon_code'           => $coupon,
                'total_discount_price'  => $couponResponse['data']['total_discount_price'],
                'total_discount_amount' => $couponResponse['data']['total_discount_amount'],
                'coupon_products'       => $couponResponse['data']['coupon_products'],
            ]);

            return response()->json([
                'success'   => true,
                'msg'       => 'Coupon Applied Successfully!',
                'data'      => $couponResponse['data'] ?? null
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }

    public function removeCoupon(Request $request){

        try {

            $coupon = $request->coupon;     

            if(!session('coupon')) 
                throw new Exception("{$coupon}, Not applied!", 403);

            $total_discount_price = session('coupon')['total_discount_price'] ?? 0;
            $total_discount_amount= session('coupon')['total_discount_amount'] ?? 0;

            if(session('coupon')['coupon_code']==$coupon){
                session()->forget('coupon');
            }

            return response()->json([
                'success'   => true,
                'msg'       => 'Coupon Removed Successfully!',
                'total_discount_price' => $total_discount_price,
                'total_discount_amount' =>$total_discount_amount,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //

            $req = $request->all();
            if(!array_key_exists('order', $req))
                throw new Exception("Invalid Request!", 403);

            $data = $req['order'] ?? null;
            if(!is_array($data))
                throw new Exception("Invalid Data Format!", 403);


            if(!array_key_exists('products', $data))
                throw new Exception("Product Missing!", 403);

            if(!count($data['products']))
                throw new Exception("Product Not Found!", 404);


            $totalQty   = 0;
            $colors     = [];
            $sizes      = [];
            $orderDetail=[];

            $order_no = auth()->guard('web')->check() ? uniqid() . '_' . auth()->guard('web')->user()->id  : uniqid();

            DB::beginTransaction();
            
            foreach ($data['products'] as $product) {
                $totalQty += (int)$product['qty'];
                if(isset($product['color']) && !is_null($product['color'])){
                    $colors []= $product['color'];
                }

                if(isset($product['size']) && !is_null($product['size'])){
                    $sizes []= $product['size'];
                }

                $couponDiscountSingleProduct = 0;
                if($arrOfCoupon = session('coupon')){
                    if(array_key_exists('coupon_products', $arrOfCoupon)){
                        foreach ($arrOfCoupon['coupon_products'] as $cProduct) {

                            if($cProduct['product_id'] == $product['product_id']){
                                $couponDiscountSingleProduct = $cProduct['coupon_price'] ?? 0;
                            }
                        }
                    }
                }

                $orderDetail[]=[
                    'order_no'          => $order_no,
                    'product_id'        => $product['product_id'] ?? null,
                    'product_name'      => $this->productName($product['product_id']),
                    'product_color'     => $product['color'] ?? null,
                    'product_size'      => $product['size'] ?? null,
                    'product_qty'       => (int)$product['qty'] ?? 0,
                    'product_price'     => floatval($product['sales_price']),
                    'discount_price'    => $couponDiscountSingleProduct,
                    'subtotal'          => (floatval($product['subtotal']) - floatval($couponDiscountSingleProduct)) ?? 0,
                ];

                $singleProduct = Product::find($product['product_id']);

                $updateproduct = $singleProduct->update([
                    'total_stock_qty'       => $singleProduct->total_stock_qty - (int)$product['qty'],
                    'total_stock_price'     => $singleProduct->total_stock_price - floatval($product['sales_price']),
                    'total_stock_out_qty'   => $singleProduct->total_stock_out_qty + (int)$product['qty'],
                    'total_stock_out_price' => $singleProduct->total_stock_out_price + floatval($product['sales_price']),
                ]);

                if(!$updateproduct)
                   throw new Exception("Unable to Update Stock Qty!", 403);
                
                if($singleProduct->is_product_variant){
                    $variantStocks = ProductVariantPrice::where('product_id', $product['product_id'])
                    ->where('color_name', $product['color'] ?? null)
                    ->where('size_name', $product['size'] ?? null)
                    ->get();

                    foreach ($variantStocks as $variantStock) {
                        ProductVariantPrice::find($variantStock->id)
                        ->update([
                            'stock_qty'     => $variantStock->stock_qty - (int)$product['qty'],
                            'stock_out_qty' => $variantStock->stock_out_qty + (int)$product['qty'],
                        ]);
                    }
                }
                   
            }

            if($totalQty < 1) 
               throw new Exception("Invalid Quantity!", 403);
               
            $userId   = auth()->guard('web')->user()->id ?? null;
            $customer = $this->getCustomer($userId);
            if(!$customer){

                $existCustomer = Customer::where('customer_phone',$req['shipment']['mobile_no'] ?? null)->first();
                if($existCustomer)
                    throw new Exception("Phone Already Exists!", 403);
                    
                $customer = Customer::create(
                    [ 
                        'user_id'          => $userId, 
                        'customer_name'    => $req['shipment']['name'] ?? null, 
                        'customer_email'   => $req['shipment']['email'] ?? null,
                        'customer_phone'   => $req['shipment']['mobile_no'] ?? null,
                        'customer_address' => $req['shipment']['address'] ?? null,
                        'is_active'        => 1,
                    ]
                );

                if(!$customer)
                    throw new Exception("Unable to create Customer!", 403);
                     
            }

            $customerCheck = $this->checkCustomerExists($customer->id);
            if(!$customerCheck){
                CustomerType::create([
                    'customer_id'   => $customer->id,
                    'customer_type' => 'ecommerce',
                ]);
            }
                
            $orderData = [
                'user_id'           => $userId,
                'customer_id'       => $customer->id ?? null,
                'customer_name'     => $req['shipment']['name'] ?? null,
                'customer_phone'    => $req['shipment']['mobile_no'] ?? null,
                'order_date'        => date('Y-m-d'),
                'order_no'          => $order_no,
                'coupon_code'       => session('coupon') ? session('coupon')['coupon_code'] : null,
                'order_sizes'       => count($sizes) ? implode(',', $sizes) : null,
                'order_colors'      => count($colors) ? implode(',', $colors) : null,
                'shipping_address'  => $req['shipment']['address'] ?? null,
                'payment_type'      => $req['shipment']['payment_type'] ?? null,
                'payment_total_price'=> 0,
                'shipment_cost'     => 0,
                'service_charge'    => 0,
                'discount_price'    => $data['total_discount_price'],
                'order_total_qty'   => $totalQty,
                'order_total_price' => $data['grand_total'],
                'order_note'        => null,
            ];

            $order = Order::create($orderData);
            if(!$order)
                throw new Exception("Unable to place order!", 403);

            $order->orderDetails()->createMany($orderDetail);
            
            Event::dispatch(new OrderEvent($order));

            DB::commit();

            // Mail::to($booking->client)->send(new BookingConfirmationMail($booking));

            session()->forget('coupon');

            Cookie::queue(Cookie::forget('productIds'));
            Cookie::queue(Cookie::forget('cartQtys'));
            

            return response()->json([
                'success'   => true,
                'msg'       => 'Order Placed Successfully!',
            ]);

        } catch (\Exception $th) {

            DB::rollBack();

            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'data'      => null
            ]);
        }
    }



    private function productName($id){
        $product = Product::find($id);
        if(!$product) return null;

        return $product->product_name;
    }


    private function getCustomer($id=null){
       return Customer::orWhere('user_id',$id)
            ->orWhere('customer_email', auth()->guard('web')->user()->email ?? null)
            ->first();
    }

    private function checkCustomerExists($id=null){
       return CustomerType::where('customer_id',$id)->where('customer_type','ecommerce')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
