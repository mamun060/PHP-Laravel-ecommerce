<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ClientLogos;
use App\Models\Custom\CustomServiceCategory;
use App\Models\Custom\CustomServiceProduct;
use App\Models\Custom\OurCustomService;
use App\Models\Shop;
use App\Models\SocialIcon;
use App\Models\WebFooter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $maxId = 0;
    protected $limit = 12;
    protected $clientLogosLimit = 12;

    public function index()
    {
        $maxId    = request()->max_id ?? $this->maxId;
        $limit    = request()->limit ?? $this->limit;
        $operator = request()->operator ?? '<';


        $customservices = OurCustomService::where('is_active',1)
                        ->orderByDesc('id')
                        ->get();

        $countCustomservicecategories= CustomServiceCategory::where('is_active', 1)->count();


        $sql = CustomServiceCategory::where('is_active', 1);
        if ($maxId) {
            $sql->where('id', $operator, $maxId);
        }

        $customservicecategories = $sql->latest()
                                ->take($limit)
                                ->get();

        if (request()->ajax()) {

            $response = $this->renderCustomServiceCategory($customservicecategories);

            return response()->json([
                'html'      => $response['html'],
                'max_id'    => $response['max_id'],
                'isLast'    => $response['isLast']
            ]);
        }


        $serviceproducts        = CustomServiceProduct::where('is_active', 1)->get();

        $shopbanner = Shop::where('is_active', 1)->first();

        $clientLogosLimit = $this->clientLogosLimit;

        $clientlogos = ClientLogos::orderByDesc('id')
            ->take($clientLogosLimit)
            ->get();

        $countClientLogos = ClientLogos::count();

        // dd($sociallink);
        return view('frontend.pages.home', compact('customservices' , 'customservicecategories' , 'serviceproducts', 'shopbanner', 'clientlogos', 'countCustomservicecategories', 'limit', 'countClientLogos', 'clientLogosLimit'));
    }


    public function home_client_loadmore(){
        $maxId    = request()->max_id ?? $this->maxId;
        $limit    = request()->limit ?? $this->clientLogosLimit;
        $operator = request()->operator ?? '<';

        $sql = ClientLogos::orderByDesc('id');
        if ($maxId) {
            $sql->where('id', $operator, $maxId);
        }

        $clientLogos = $sql->take($limit)->get();

        if (request()->ajax()) {

            $response = $this->renderClientLogos($clientLogos);

            return response()->json([
                'html'      => $response['html'],
                'max_id'    => $response['max_id'],
                'isLast'    => $response['isLast']
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getProduct($category_id)
    {
        try {

            $products = CustomServiceProduct::where([
                ['category_id', $category_id],
                ['is_active', 1]
            ])
            ->get();
            
            return response()->json($products);

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
    public function store(Request $request)
    {
        //
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


    private function renderCustomServiceCategory($customservicecategories){
    
       try{


            $lastId         = 0;
            $isLastRecord   = false;
            $lastData       = CustomServiceCategory::first();
            if ($lastData) {
                $lastId = $lastData->id;
            }

            $maxCatId       = 0;
            $html           = "";

            if ($customservicecategories) :
                foreach ($customservicecategories as $customservicecategory) :
                    $maxCatId = $customservicecategory->id;
                    if ($lastId == $maxCatId) $isLastRecord = true;

                    $imageSRC = $customservicecategory->category_thumbnail ? asset($customservicecategory->category_thumbnail) : asset('assets/frontend/img/product/1234.png');
                    $html .= "<div class=\"col-md-4 col-sm-12 mb-2\">
                            <div class=\"product-content d-flex\">
        
                                <div class=\"product-img\">
                                     <img src=\"{$imageSRC}\" alt=\"Product img\">
                                </div>
            
                                <div class=\"product-details text-center\">
                                    <h3 class=\"product-title\"> {$customservicecategory->category_name} </h3>
                                    <p class=\"product-text\">  {$customservicecategory->category_description} </p>
                                    <a href=\"javascript:void(0)\" id=\"category_id\" data-categoryid=\"{$customservicecategory->id}\" type=\"button\" class=\"product-button customize-btn\"> কাস্টমাইজ করুন </a>
                                </div>
            
                            </div>
                        </div>";
                endforeach;
            endif;

         return [
                'html'   => $html,
                'max_id' => $maxCatId,
                'isLast' => $isLastRecord
            ];

        } catch (\Throwable $th) {

            return [
                'html'   => null,
                'max_id' => 0,
                'isLast' => false
            ];
        }
    }


    private function renderClientLogos($logos)
    {

        try {


            $lastId         = 0;
            $isLastRecord   = false;
            $lastData       = ClientLogos::first();
            if ($lastData) {
                $lastId = $lastData->id;
            }

            $maxLogoId       = 0;
            $html           = "";

            if ($logos) :
                foreach ($logos as $clientlogo) :
                    $maxLogoId = $clientlogo->id;
                    if ($lastId == $maxLogoId) $isLastRecord = true;

                    $imageSRC = $clientlogo->logo ? asset($clientlogo->logo) : null;
                    $html .= "<div class=\"col-md-2\">
                                <div class=\"single-client text-center m-1\">
                                    <img src=\"{$imageSRC}\" alt=\"Logo\">
                                </div>
                            </div>";
                endforeach;
            endif;

            return [
                'html'   => $html,
                'max_id' => $maxLogoId,
                'isLast' => $isLastRecord
            ];
        } catch (\Throwable $th) {

            return [
                'html'   => null,
                'max_id' => 0,
                'isLast' => false
            ];
        }
    }
}
