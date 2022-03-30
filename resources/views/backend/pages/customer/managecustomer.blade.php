@extends('backend.layouts.master')

@section('title','Manage Customer')

@section('content')
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Manage Customer</a> </h6>
                <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> Customer</i></button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Cutomer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @isset($customers)
                                @foreach ($customers as $customer)
                                    <tr customer-data="{{json_encode($customer)}}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $customer->customer_email ?? 'N/A' }}</td>
                                        <td>{{ $customer->customer_phone ?? 'N/A' }}</td>
                                        <td>{{ $customer->customer_address ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            {!! $customer->is_active ? '<span class="badge badge-success">Active </span>' : '<span class="badge badge-danger">In-Active </span>' !!}
                                        </td>
                                        <td class="text-center">
                                            {{-- <a href="" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                            <a href="javascript:void(0)" class="fa fa-edit mx-2 text-warning text-decoration-none update"></a>
                                            <a href="{{route('admin.customer.destroy', $customer->id )}}" class="fa fa-trash text-danger text-decoration-none delete"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                            
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    
    </div>

    <div class="modal fade" id="customerModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold modal-heading" id="exampleModalLabel"><span class="heading">Create</span> Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div id="service-container">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold bg-custom-booking">Customer Information</h5>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Customer Name<span style="color: red;" class="req">*</span></label>
                                    <input type="text" class="form-control" id="customer_name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Customer Email</label>
                                    <input type="email" class="form-control" id="customer_email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Customer Phone</label>
                                    <input type="number" class="form-control" id="customer_phone">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Customer Address</label>
                                    <input type="text" class="form-control" id="customer_address">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Is Active</label><br>
                                    <input type="radio" name="is_active" id="isActive" checked>
                                    <label for="isActive">Active</label>
                                    <input type="radio" name="is_active" id="isInActive">
                                    <label for="isInActive">Inactive</label>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <div class="w-100">
                        <button type="button" id="reset" class="btn btn-sm btn-secondary"><i class="fa fa-sync"></i> Reset</button>
                        <button id="customer_save_btn" type="button" class="save_btn btn btn-sm btn-success float-right"><i class="fa fa-save"></i> <span>Save</span></button>
                        <button id="customer_update_btn" type="button" class="save_btn btn btn-sm btn-success float-right d-none"><i class="fa fa-save"></i> <span>Update</span></button>
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
    <link rel="stylesheet" href="{{ asset('assets/backend/css/supplier/supplier.css')}}">
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
            $(document).on('click','#customer_save_btn', submitToDatabase)

            $(document).on('click' , '#reset', resetForm)
            $(document).on('click','.delete', deleteToDatabase)

            $(document).on('click' , '.update', showUpdateModal)
            $(document).on('click','#customer_update_btn', updateToDatabase)

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
            showModal('#customerModal');
            $('#customer_save_btn').removeClass('d-none');
            $('#customer_update_btn').addClass('d-none');
            $('#customerModal .heading').text('Create');
            resetData();
        }

        function deleteToDatabase(e){
            e.preventDefault();

            let elem = $(this),
            href = elem.attr('href');
            if(confirm("Are you sure to delete the record?")){
                ajaxFormToken();

                $.ajax({
                    url     : href, 
                    method  : "DELETE",
                    data    : {},
                    success(res){

                        // console.log(res?.data);
                        if(res?.success){
                            _toastMsg(res?.msg ?? 'Success!', 'success');
                            resetData();

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error(err){
                        console.log(err);
                        _toastMsg((err.responseJSON?.msg) ?? 'Something wents wrong!')
                    },
                });
            }
        }


        function resetForm(){
            resetData();
        }

        function submitToDatabase(){
            //

            ajaxFormToken();

            let obj = {
                url     : `{{ route('admin.customer.store')}}`, 
                method  : "POST",
                data    : formatData(),
            };

            ajaxRequest(obj, { reload: true, timer: 2000 })
            resetData()
            // hideModal('#customerModal');
        }

        function showUpdateModal(){
            resetData();

            let customer = $(this).closest('tr').attr('customer-data');

            if(customer){

                $('#customer_save_btn').addClass('d-none');
                $('#customer_update_btn').removeClass('d-none');

                customer = JSON.parse(customer);

                $('#customerModal .heading').text('Edit').attr('data-id', customer?.id)

                $('#customer_name').val(customer?.customer_name)
                $('#customer_email').val(customer?.customer_email)
                $('#customer_phone').val(customer?.customer_phone)
                $('#customer_address').val(customer?.customer_address)

                if(customer?.is_active){
                    $('#isActive').prop('checked',true)
                }else{
                    $('#isInActive').prop('checked',true)
                }

                showModal('#customerModal');
            }
        }

        function updateToDatabase(){
            ajaxFormToken();

            let id  = $('#customerModal .heading').attr('data-id');
            let obj = {
                url     : `{{ route('admin.customer.update', '' ) }}/${id}`, 
                method  : "PUT",
                data    : formatData(),
            };

            ajaxRequest(obj, { reload: true, timer: 2000 })

            resetData();

            hideModal('#customerModal');
        }

        function formatData(){
            return {
                customer_name    : $('#customer_name').val().trim(),
                customer_email   : $('#customer_email').val().trim(),
                customer_phone   : $('#customer_phone').val(),
                customer_address : $('#customer_address').val(),
                is_active        : $('#isActive').is(':checked') ? 1 : 0,
            }
        }

        function resetData(){
            $('#customer_name').val(null),
            $('#customer_email').val(null),
            $('#customer_phone').val(null),
            $('#customer_address').val(null),
            $('#isActive').prop('checked', true)
        }


    </script>
@endpush
