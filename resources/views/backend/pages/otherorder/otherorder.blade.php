@extends('backend.layouts.master')

@section('title','Manage Other Order')

@section('content')
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Other Orders</a> </h6>
                <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> Order</i></button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order Date</th>
                                <th>Order NO</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Advance Amount</th>
                                <th>Due Amount</th>
                                <th>Mobile</th>
                                <th>Institute Description</th>
                                <th>Note</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @isset($otherOrders)
                                @foreach ($otherOrders as $otherOrder)
                                    <tr otherorder-data="{{ json_encode($otherOrder) }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $otherOrder->order_date ?? 'N/A' }}</td>
                                        <td>{{ $otherOrder->order_no  ?? 'N/A' }}</td>
                                        <td>{{ $otherOrder->category_name  ?? 'N/A' }}</td>
                                        <td>{{ $otherOrder->order_qty  ?? '0.0' }}</td>
                                        <td>{{ $otherOrder->price  ?? '0.0' }}</td>
                                        <td>{{ $otherOrder->total_order_price  ?? '0.0' }}</td>
                                        <td>{{ $otherOrder->advance_balance  ?? '0.0' }}</td>
                                        <td>{{ $otherOrder->due_price  ?? '0.0' }}</td>
                                        <td>{{ $otherOrder->moible_no  ?? 'N/A' }}</td>
                                        <td>{{ $otherOrder->institute_description  ?? 'N/A' }}</td>
                                        <td>{{ $otherOrder->note  ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            {{-- <a href="javascript:void(0)" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                            <a href="javascript:void(0)" class="fa fa-edit mx-2 text-warning text-decoration-none update"></a>
                                            <a href="{{ route('admin.otherOrder.destroy',$otherOrder->id )}}" class="fa fa-trash text-danger text-decoration-none delete"></a>
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

    <div class="modal fade" id="categoryModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold modal-heading" id="exampleModalLabel"><span class="heading">Create</span> Other Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div id="service-container">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_date">Order Date</label>
                                    <input type="text" name="order_date" id="order_date" class="form-control" placeholder="Order Date">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_no">Order NO</label>
                                    <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Order NO" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_name">Category</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="text" name="qty" id="qty" class="form-control calprice" placeholder="Quantity" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control calprice" placeholder="Price" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_price">Total Price</label>
                                    <input type="text" name="total_price" id="total_price" class="form-control totalCalprice" placeholder="Total Price" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="advance_price">Advance Price</label>
                                    <input type="text" name="advance_price" id="advance_price" class="form-control totalCalprice" placeholder="Advance Price" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_price">Due Price</label>
                                    <input type="text" name="due_price" readonly id="due_price" class="form-control" placeholder="Due Price" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="institute_description">Institute Description</label>
                                    <textarea name="institute_description" id="institute_description" cols="" rows="1" class="form-control" placeholder="Institute Description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note" cols="" rows="1" class="form-control" placeholder="Note"></textarea>
                                </div>
                            </div>

                           
    
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <div class="w-100">
                        <button type="button" id="reset" class="btn btn-sm btn-secondary"><i class="fa fa-sync"></i> Reset</button>
                        <button id="otherOrder_save_btn" type="button" class="save_btn btn btn-sm btn-success float-right"><i class="fa fa-save"></i> <span>Save</span></button>
                        <button id="otherOrder_update_btn" type="button" class="save_btn btn btn-sm btn-success float-right d-none"><i class="fa fa-save"></i> <span>Update</span></button>
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
            $(document).on('click','#otherOrder_save_btn', submitToDatabase)
            $(document).on('input keyup change', ".calprice", priceCalculation)
            $(document).on('input keyup change', ".totalCalprice", totalPriceCalculation)
            $(document).on('click', '.delete', deleteToDatabase)
            $(document).on('click','#reset', resetForm)

            $(document).on('click', '.update', showUpdateModal)
            $(document).on('click', '#otherOrder_update_btn', updateToDatabase)
        });

        function createModal(){
            showModal('#categoryModal');
            $('#otherOrder_save_btn').removeClass('d-none');
            $('#otherOrder_update_btn').addClass('d-none');
            $('#categoryModal .heading').text('Create');
            resetData();
        }

        function showUpdateModal(){
            resetData();

            let orderData = $(this).closest('tr').attr('otherorder-data');

            if(orderData){

                $('#otherOrder_save_btn').addClass('d-none');
                $('#otherOrder_update_btn').removeClass('d-none');

                orderData = JSON.parse(orderData);

                $('#categoryModal .heading').text('Edit').attr('data-id', orderData?.id)

                $('#order_date').val(orderData?.order_date)
                $('#order_no').val(orderData?.order_no)
                $('#category_name').val(orderData?.category_name)
                $('#qty').val(orderData?.order_qty)
                $('#price').val(orderData?.price)
                $('#total_price').val(orderData?.total_order_price)
                $('#advance_price').val(orderData?.advance_balance)
                $('#due_price').val(orderData?.due_price)
                $('#mobile').val(orderData?.moible_no)
                $('#institute_description').val(orderData?.institute_description)
                $('#note').val(orderData?.note)

                showModal('#categoryModal');
            }
        }

        function updateToDatabase(){
            ajaxFormToken();

            let id  = $('#categoryModal .heading').attr('data-id');
            let obj = {
                url     : `{{ route('admin.otherOrder.update', '' ) }}/${id}`, 
                method  : "PUT",
                data    : formatData(),
            };

            ajaxRequest(obj, { reload: true, timer: 2000 })

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

        function priceCalculation(){
            let price   = Number($('#price').val().trim() ?? 0);
            let qty     = Number($('#qty').val().trim() ?? 0);

            if( price < 0 ){
                price  =0;
                $('#price').val(price)
            }
            if( qty < 0 ){
                qty  =0;
                $('#qty').val(qty)
            }

            let total   = price * qty;
            $('#total_price').val(total);
        }

        function totalPriceCalculation(){
            let total_price   = Number($('#total_price').val().trim() ?? 0);
            let advance_price     = Number($('#advance_price').val().trim() ?? 0);

            if( total_price < 0 ){
                total_price  =0;
                $('#total_price').val(total_price)
            }

            if( advance_price < 0 ){
                advance_price  =0;
                $('#advance_price').val(advance_price)
            }

            let total   = total_price - advance_price;
            $('#due_price').val(total).prop('readonly', true);
        }

        function init(){

            let arr=[
                {
                    dropdownParent  : '#categoryModal',
                    selector        : `#email_template`,
                    type            : 'select',
                },
                {
                    selector        : `#order_date`,
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

        function resetForm(){
            resetData()
        }

        function submitToDatabase(){
            //

            ajaxFormToken();

            let obj = {
                url     : `{{ route('admin.otherOrder.store')}}`, 
                method  : "POST",
                data    : formatData(),
            };

            ajaxRequest(obj, { reload: true, timer: 2000 })
            resetData()
        }

        function formatData(){
            return {
                order_date          : $('#order_date').val().trim(),
                order_no            : $('#order_no').val().trim(),
                category_name       : $('#category_name').val().trim(),
                order_qty           : $('#qty').val().trim(),
                price               : $('#price').val().trim(),
                total_order_price   : $('#total_price').val().trim(),
                advance_balance     : $('#advance_price').val().trim(),
                due_price           : $('#due_price').val().trim(),
                moible_no           : $('#mobile').val().trim(),
                institute_description : $('#institute_description').val().trim(),
                note                : $('#note').val().trim(),
            }
        }

        function resetData(){
            $('#order_date').val(null)
            $('#order_no').val(null)
            $('#category_name').val(null)
            $('#qty').val(null)
            $('#price').val(null)
            $('#total_price').val(null)
            $('#advance_price').val(null)
            $('#due_price').val(null)
            $('#mobile').val(null)
            $('#institute_description').val(null)
            $('#note').val(null)
        }

    </script>
@endpush
