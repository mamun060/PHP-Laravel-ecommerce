@extends('backend.layouts.master')

@section('title', 'Manage Order')

@section('content')
<div>
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Manage Order</a> </h6>
                <button class="btn btn-sm btn-info"><a class="text-white" href="{{ route('admin.order_add') }}"><i class="fa fa-plus"> Order</i></a></button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order NO</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th width="70" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>01</td>
                                <td>std000001</td>
                                <td>Alauddin</td>
                                <td>03/03/2022</td>
                                <td>5000.00Tk</td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        Pending
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="" class="fa fa-eye text-info text-decoration-none"></a>
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>std000001</td>
                                <td>Alauddin</td>
                                <td>03/03/2022</td>
                                <td>5000.00Tk</td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        Pending
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="" class="fa fa-eye text-info text-decoration-none"></a>
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>std000001</td>
                                <td>Alauddin</td>
                                <td>03/03/2022</td>
                                <td>5000.00Tk</td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        Pending
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="" class="fa fa-eye text-info text-decoration-none"></a>
                                    <a href="" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                    <a href="javascript:void(0)" class="fa fa-trash text-danger text-decoration-none"></a>
                                </td>
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
</div>
@endsection

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/currency/currency.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/product/product.css') }}">
@endpush

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/backend/libs/demo/datatables-demo.js') }}"></script>
@endpush