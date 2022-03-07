@extends('backend.layouts.master')

@section('title','Category pages')

@section('content')
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Categories</a> </h6>
                <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> Category</i></button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Category Image</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1001</th>
                                <th>Clothing</th>
                                <th>Womens gfgfgf</th>
                                <th>Category Images</th>
                                <th class="text-center">
                                <span class="badge badge-success">
                                    Active
                                </span>
                                </th>
                                <th class="text-center">
                                    {{-- <a href="" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </th>
                            </tr>
                            <tr>
                                <th>1001</th>
                                <th>Clothing</th>
                                <th>Womens gfgfgf</th>
                                <th>Category Images</th>
                                <th class="text-center">
                                <span class="badge badge-success">
                                    Active
                                </span>
                                </th>
                                <th class="text-center">
                                    {{-- <a href="" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </th>
                            </tr>
                            <tr>
                                <th>1001</th>
                                <th>Clothing</th>
                                <th>Womens gfgfgf</th>
                                <th>Category Images</th>
                                <th class="text-center">
                                <span class="badge badge-success">
                                    Active
                                </span>
                                </th>
                                <th class="text-center">
                                    {{-- <a href="" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </th>
                            </tr>
                            <tr>
                                <th>1001</th>
                                <th>Clothing</th>
                                <th>Womens gfgfgf</th>
                                <th>Category Images</th>
                                <th class="text-center">
                                <span class="badge badge-success">
                                    Active
                                </span>
                                </th>
                                <th class="text-center">
                                    {{-- <a href="" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </th>
                            </tr>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot> --}}

                    </table>
                </div>
            </div>
        </div>
    
    </div>

    <div class="modal fade" id="categoryModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold modal-heading" id="exampleModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div id="service-container">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold bg-custom-booking">Category Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Category Name<span style="color: red;" class="req">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            {{-- <div class="col-md-6" data-col="col">
                                <div class="form-group">
                                    <label for="stuff">Parent Category<span style="color: red;" class="req">*</span></label>
                                    <select name="stuff" class="stuff" data-required id="stuff" data-placeholder="Select a Staff"></select>
                                </div>
                                <span class="v-msg"></span>
                            </div>
     --}}
                            {{-- <div class="col-md-6" data-col="col">
                                <div class="form-group">
                                    <label for="booking_date">Booking Date <span style="color: red;" class="req">*</span></label>
                                    <input type="text" data-required autocomplete="off" class="form-control" id="booking_date" name="booking_date">
                                </div>
                                <span class="v-msg"></span>
                            </div> --}}

                            <div class="col-md-12">
                                <div class="form-group">
                                   <label for="">Category Description</label>
                                   {{-- <textarea rows="4" type="text" class="form-control"> --}}
                                    <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Category Image</label>
                                    <input class="d-flex align-items-center" type="file" name="" id="">
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <div class="w-100">
                        <button type="button" id="reset" class="btn btn-sm btn-secondary"><i class="fa fa-sync"></i> Reset</button>
                        <button id="category_save_btn" type="button" class="save_btn btn btn-sm btn-success float-right"><i class="fa fa-save"></i> <span>Save</span></button>
                        <button type="button" class="btn btn-sm btn-danger float-right mx-1" data-dismiss="modal">Close</button>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    
@endsection

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/currency/currency.css')}}" rel="stylesheet">
@endpush

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/backend/libs/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function(){
            init();

            $(document).on('click','#add', createModal)
            $(document).on('click','#category_save_btn', submitToDatabase)
        });


        function init(){

            let arr=[
                {
                    dropdownParent  : '#categoryModal',
                    selector        : `#stuff`,
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
