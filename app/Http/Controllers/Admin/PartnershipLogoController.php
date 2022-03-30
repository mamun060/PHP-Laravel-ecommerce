<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PartnershipLogo;
use Illuminate\Http\Request;

class PartnershipLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.cms_settings.ourpartnerlogo');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnershipLogo  $partnershipLogo
     * @return \Illuminate\Http\Response
     */
    public function show(PartnershipLogo $partnershipLogo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartnershipLogo  $partnershipLogo
     * @return \Illuminate\Http\Response
     */
    public function edit(PartnershipLogo $partnershipLogo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartnershipLogo  $partnershipLogo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartnershipLogo $partnershipLogo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnershipLogo  $partnershipLogo
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnershipLogo $partnershipLogo)
    {
        //
    }
}
