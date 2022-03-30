<?php

use App\Models\Notification;
use Illuminate\Support\Facades\DB;

if (!function_exists('check_internet')) {

    function check_internet()
    {
        try {
            $host_name  = 'www.google.com';
            $port_no    = '80';

            $st = (bool)@fsockopen($host_name, $port_no, $err_no, $err_str, 10);
            if (!$st)
                throw new Exception("Please check Your Internet!", 403);

            return [
                'success'    => true,
                'msg'         => 'OK',
                'code'        => 200
            ];
        } catch (Exception $e) {
            return [
                'success'    => false,
                'msg'         => $e->getMessage(),
                'code'        => $e->getCode()
            ];
        }
    }
}



if (!function_exists('renderFileInput')) {

    function renderFileInput(array $array=[])
    {
        $id                 = $array['id'] ?? 'image'; // categoryImage
        $previewId          = $array['previewId'] ?? 'img-preview';
        $previewImageStyle  = $array['previewImageStyle'] ?? 'cursor:pointer;width:300px; height: 300px !important;';
        $defaultImageSrc    = $array['imageSrc'] ?? 'assets/img/blank-img.png';

        return "<div class=\"input-group\">
                <div class=\"input-group-append\">
                    <button title=\"Image Preview\" class=\"btn btn-primary collapsed\" type=\"button\" data-toggle=\"collapse\"
                        data-target=\"#collapseExample_{$id}\" aria-expanded=\"false\" aria-controls=\"collapseExample\"><i class=\"fa fa-image fa-lg\"></i></button>
                </div>
                <input type=\"file\" name=\"photo\" id=\"{$id}\" class=\"form-control\" accept=\"image/*\">
            </div>
        
            <div class=\"collapse pt-4\" id=\"collapseExample_{$id}\">
                <div class=\"d-flex justify-content-center\"
                    onclick=\" javascript: document.getElementById('$id').click() \">
                    <img title=\"Click to upload image\" src=\"$defaultImageSrc\" alt=\"Default Image\"
                        id=\"$previewId\" class=\"img-fluid img-responsive img-thumbnail\"
                        ondragstart=\"javascript: return false;\" style=\"$previewImageStyle\">
                </div>
            </div>";
    }
}


if (!function_exists('profilePhoto')) {
    function profilePhoto($path=null,array $attributes=[]){

        $profilePath = $path ? asset($path) : asset('assets/frontend/img/profile/profile-picture.png');

        $result = "<img src=\"$profilePath\" " . join(' ', array_map(function ($key) use ($attributes) {
            if (is_bool($attributes[$key])) {
                return $attributes[$key] ? $key : '';
            }

            return $key . '="' . $attributes[$key] . '"';

        }, array_keys($attributes))) . ' alt="Profile Image" >';

        return $result;

    }
}



if (!function_exists('hasProfile')){
    function hasProfile($guard="web"){
        return auth()->guard($guard)->user()->profile;
    }
}

if (!function_exists('salesPrice')){
    function salesPrice($product){
        return number_format($product->sales_price, 2);
        // return number_format(($product->total_product_unit_price - ($product->total_product_unit_price *  ($product->product_discount / 100))) / $product->total_product_qty ?? 0.0 , 2);
    }

}


if (!function_exists('wholesalesPrice')) {
    function wholesalesPrice($product)
    {
        return number_format(($product->total_product_wholesale_price / $product->total_product_qty) ?? 0.0, 2);
    }
}


if (!function_exists('matchColor')) {
    function matchColor($color_name=null)
    {
        return preg_match('/white|#f{1,5}/im', $color_name);
    }
}


if (!function_exists('loadMoreButton')) {
    function loadMoreButton($dataURI=null, $maxId="1", $limit="10", $btnClass="btn btn-dark btn-sm mx-5")
    {
        return "
            <button data-uri=\"{$dataURI}\" class=\"{$btnClass} loadMoreBtn\" data-filter-maxid=\"\" data-maxid=\"{$maxId}\" data-limit=\"{$limit}\">Load More</button>
        ";
    }
}


if (!function_exists('getUnreadNotification')) {
    function getUnreadNotification()
    {
        return Notification::whereNull('read_at')->get();
    }
}