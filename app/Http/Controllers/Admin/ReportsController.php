<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Sales report
     */
    public function salesreport(){
        return view('backend.pages.report.salesreport');
    }

    /**
     * purchase report
     */
    public function purchasereport(){
        return view('backend.pages.report.purchasereport');
    }

    /**
     * Product tax report
     */
    public function producttaxreport(){
        return view('backend.pages.report.producttaxreport');
    }

    /**
     * Invoice tax report
     */

     public function invoicetaxreport(){
         return view('backend.pages.report.invoicetaxreport');
     }

}
