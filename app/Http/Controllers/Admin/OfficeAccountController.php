<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OfficeAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeAccountRequest;
use Exception;

class OfficeAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officeaccounts = OfficeAccount::orderByDesc('id')->get();
        return view('backend.pages.account.accountmanage', compact('officeaccounts'));
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
    public function store(OfficeAccountRequest $request)
    {
        try {
            $data                       = $request->all();
            $data['created_by']         = auth()->guard('admin')->user()->id ?? null;
            $data['created_by_name']    = auth()->guard('admin')->user()->name ?? null;
            $officeaccount   = OfficeAccount::create($data);
            if(!$officeaccount)
                throw new Exception("Unable to create Office Account!", 403);

            return response()->json([
                'success'   => true,
                'msg'       => 'Office Account Created Successfully!',
                'data'      => $officeaccount
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
     * @param  \App\Models\OfficeAccount  $officeAccount
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeAccount $officeAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeAccount  $officeAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeAccount $officeAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeAccount  $officeAccount
     * @return \Illuminate\Http\Response
     */
    public function update(OfficeAccountRequest $request, OfficeAccount $officeAccount)
    {
        try {

            $data                       = $request->all();
            $data['updated_by']         = auth()->guard('admin')->user()->id ?? null;
            $data['updated_by_name']    = auth()->guard('admin')->user()->name ?? null;

            $accountStatus  = $officeAccount->update($data);
            if(!$accountStatus)
                throw new Exception("Unable to Update Office Account!", 403);

            return response()->json([
                'success'   => true,
                'msg'       => 'Office Account Updated Successfully!',
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
     * @param  \App\Models\OfficeAccount  $officeAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeAccount $officeAccount)
    {
        try {

            $isDeleted = $officeAccount->delete();
            if(!$isDeleted)
                throw new Exception("Unable to delete Office Account!", 403);
                
            return response()->json([
                'success'   => true,
                'msg'       => 'Office Account Deleted Successfully!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage()
            ]);
        }
    }


}
