@extends('backend.layouts.master');

@section('title', 'Add Product')

@section('content')
<div class="container card p-3 shadow">
    <h4 class="text-dark f-2x font-weight-bold text-dark">Add Product Information</h4>
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Product Name<span style="color: red;" class="req">*</span></label>
                <input name="product_name" type="text" class="form-control" placeholder="Product Name">
            </div>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="category"> Category<span style="color: red;" class="req">*</span></label>
                <select name="category" class="category" data-required id="category" data-placeholder="Select Category"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="subcategory">Sub Category</label>
                <select name="subcategory" class="subcategory" data-required id="subcategory" data-placeholder="Select Sub Category"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="color"> Color</label>
                <select name="color" class="color" data-required id="color" data-placeholder="Select Color"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="size">Size</label>
                <select name="size" class="size" data-required id="size" data-placeholder="Select Size"></select>
            </div>
            <span class="v-msg"></span>
        </div>
        
        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="brand"> Brand</label>
                <select name="brand" class="brand" data-required id="brand" data-placeholder="Select brand"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="currency">Currency</label>
                <select name="currency" class="currency" data-required id="currency" data-placeholder="Select currency"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Stock</label>
                <input name="stock" type="number" class="form-control" placeholder="Stock">
            </div>
        </div>

        <div class="col-md-6" data-col="col">
            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags" class="tags" data-required id="tags" data-placeholder="Select Tags"></select>
            </div>
            <span class="v-msg"></span>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="price">Unit Price</label>
                <input name="unit_price" type="number" class="form-control" placeholder="Product Price">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="discount">Discount</label>
                <input name="discount" type="number" class="form-control" placeholder="Discount">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="default_image">Thumbnail Image</label><br>
                <input name="default_image" type="file" id="default_image">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="product_gallery">Gallery Image</label><br>
                <input name="product_gallery" type="file" multiple id="product_gallery">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea name="description" id="" cols="" rows="5" class="form-control" placeholder="Product Description"></textarea>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="form-group">
                <input type="checkbox" name="allow_review" id="allow_review">
                <label for="allow_review"> Allow Review </label>
            </div>
        </div>

        <div class="col-md-12">
            <div class="w-100">
                <button type="button" id="reset" class="btn btn-sm btn-secondary"><i class="fa fa-sync"></i> Reset</button>
                <button id="category_save_btn" type="button" class="save_btn btn btn-sm btn-success float-right"><i class="fa fa-save"></i> <span>Submit</span></button>
                <button type="button" class="btn btn-sm btn-danger float-right mx-1" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>
@endsection

@push('css')
    <link href="{{ asset('assets/backend/css/currency/currency.css')}}" rel="stylesheet">
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
                selector        : `#subcategory`,
                type            : 'select',
            },
            {
                selector        : `#color`,
                type            : 'select'
            },
            {
                selector        : `#size`,
                type            : 'select',
            },
            {
                selector        : `#tags`,
                type            : 'select'
            },
            {
                selector        : `.category`,
                type            : 'select',
            },
            {
                selector        : `.brand`,
                type            : 'select'
            },
            {
                selector        : `.currency`,
                type            : 'select'
            }
        ];

        globeInit(arr);

        // $(`.category`).select2({
        //     width           : '100%',
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