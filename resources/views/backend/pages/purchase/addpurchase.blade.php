@extends('backend.layouts.master')

@section('title', 'Add Purchase')

@section('content')
    <div>
        <div class="container card p-3 shadow">
            <h4 class="text-dark font-weight-bold">Add Purchase List</h4>
            <div class="row">
                <div class="col-md-6" data-col="col">
                    <div class="form-group">
                        <label for="stuff"> Supplier<span style="color: red;" class="req">*</span></label>
                        <select name="supplier" class="supplier" data-required id="supplier" data-placeholder="Select Supplier"></select>
                    </div>
                    <span class="v-msg"></span>
                </div>

                <div class="col-md-6" data-col="col">
                    <div class="form-group">
                        <label for="booking_date">Purchase Date <span style="color: red;" class="req">*</span></label>
                        <input type="text" data-required autocomplete="off" class="form-control" id="booking_date" name="booking_date">
                    </div>
                    <span class="v-msg"></span>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Invoice Number<span style="color: red;" class="req">*</span></label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Details</label>
                        {{-- <input type="text" class="form-control" placeholder=""> --}}
                        <textarea class="form-control" name="" id="" cols="0" rows="1"  placeholder=""></textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive w-100">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Item Information</th>
                                    <th>Color</th>
                                    <th width="200">Size</th>
                                    <th width="100" class="text-center">Qty</th>
                                    <th width="150" class="text-center">Unit Price</th>
                                    <th width="150" class="text-center">Total</th>
                                    <th width="100" class="text-center">
                                        <button class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="color" class="color" data-required id="color" data-placeholder="Select Color"></select>
                                        </div>
                                        <span class="v-msg"></span>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="size" class="size" data-required id="size" multiple data-placeholder="Select Sizes"></select>
                                        </div>
                                        <span class="v-msg"></span>
                                    </td>
                                    <td >
                                        <input type="number" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <i class="fa fa-times text-danger fa-lg" type="button"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-success text-right outline-none"> <i class="fa fa-save"></i> Submit</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/purchase/addpurchase.css')}}">
@endpush

@push('js')
<script>
    $(document).ready(function(){
        init();

        $(document).on('click','#add', createModal)
        $(document).on('click','#category_save_btn', submitToDatabase)
    });


    function init(){

        let arr=[
            {
                selector        : `#supplier`,
                type            : 'select',
            },
            {
                selector        : `#color`,
                type            : 'select',
            },
            {
                selector        : `#size`,
                type            : 'select',
            },
            {
                selector        : `#booking_date`,
                type            : 'date',
                format          : 'yyyy-mm-dd',
            },
        ];

        globeInit(arr);

        // $(`#stuff`).select2({
        //     width           : '100%',
        //     dropdownParent  : $('#categoryModal'),
        //     theme           : 'bootstrap4',
        // }).val(null).trigger('change')


        // $('#booking_date').datepicker({
        //     autoclose : true,
        //     clearBtn : false,
        //     todayBtn : true,
        //     todayHighlight : true,
        //     orientation : 'bottom',
        //     format : 'yyyy-mm-dd',
        // })
    }


    function createModal(){
        showModal('#categoryModal');
    }

    function submitToDatabase(){
        //

        ajaxFormToken();

        let obj = {
            url     : ``, 
            method  : "POST",
            data    : {},
        };

        ajaxRequest(obj);

        hideModal('#categoryModal');
    }

</script>
@endpush

