<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Micro Media')</title>

    {{-- libs css goes here --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/bootstrap5/bootstrap5.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend/libs/fontawesome6/all.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- main css goes here --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/master.css') }}">

    @stack('css')

</head>

<body>

    {{-- -------- header -------------------------------  --}}
    @includeIf('frontend.layouts.partials.topbar')
    @includeIf('frontend.layouts.partials.header')
    {{-- -------- header -------------------------------  --}}

    {{-- ------------- content area ---------------------------  --}}
    @hasSection('content')
        @yield('content')
    @endIf
    
    @sectionMissing('content')
        <div class="py-5 mx-5">
            <h2 class="text-center text-uppercase font-weight-bold display-5 alert alert-danger alert-heading">No content Found</h2>
        </div>
    @endIf
    {{-- ------------- content area ---------------------------  --}}

    {{-- -------- footer ------------------------------- --}}
    @includeIf('frontend.layouts.partials.footer')
    {{-- -------- footer ---------------------------------}}


    <div class="modal fade" style="z-index: 22001;" id="orderTrackModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modal-dialog-scrollable">
    
                <div class="modal-header">
                    <h5 class="modal-title text-center mx-auto" id="exampleModalLabel "> আপনার অর্ডার ট্রাক করুন! </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body">
    
                    <div class="row track-order-group mb-5">
                        <div class="form-group">
                            <input type="text" placeholder="Enter Order No" class="form-control order-track-input border">
                        </div>
                    </div>

                    <div class="row order-track-row" style="display: none;" id="trackOrderRow"></div>

                    <div class="row px-3 order-not-found" style="display: none;">
                        <div class="col-md-12 alert alert-danger">
                            <h2>404</h2>
                            <h6>Oops ! No Order Found!</h6>
                        </div>
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>

</body>

<script src="{{ asset('assets/common_assets/libs/jquery/jquery.min.js') }}"> </script>
<script src="{{ asset('assets/frontend/libs/bootstrap5/boostrap5.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/libs/fontawesome6/all.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/notifications/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/config.js') }}"></script>
<script src="{{ asset('assets/common_assets/js/cart.js') }}"></script>
<script src="{{ asset('assets/common_assets/js/wish.js') }}"></script>
<script src="{{ asset('assets/common_assets/js/search.js') }}"></script>

<script>
    $(document).ready(function(){
        $(document).on('click','.ordertraking > a', openTrackModal)
        $(document).on('click','.ordertraking-footer > a', openTrackModal)
        $(document).on('change','.order-track-input', callToTrack)
        $(document).on('click','.loadMoreBtn', loadMoreItems)

        activeNavMenu()
    })


    function callToTrack(){
        let orderNo = $(this).val();

        ajaxFormToken()

        $.ajax({
            url     : `{{ route('trackOrder') }}`,
            method  : 'POST',
            data: { order_no: orderNo},
            success(res){
                console.log(res);
                if(res.success && res.data){
                    $('.order-track-row').show();
                    $('.order-not-found').hide();
                    renderOrderStatus(res)
                }else{
                    $('.order-not-found').show();
                    $('.order-track-row').hide();
                }
            },
            error(err){
                console.log(err);
                $('.order-not-found').show();
                $('.order-track-row').hide();
            },
        })

    }


    function renderOrderStatus(res){

        let from = res.order_from;
        let data = res.data;
        let pattern = /ecomerce/im;
        let html = "";

        if(pattern.test(from)){
            html = `<div class="container-fluid">
                <article class="card">
                    <header class="card-header bg-danger text-white"> <b> My Orders / Tracking </b> </header>
                    <div class="card-body">
            
                        <div class="row">
                            <div class="col-md-2">
                                <b> Order No. </b><br>
                                ${data.order_no ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Order Date </b><br>
                                ${data.order_date ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Shipping By - ${data.customer_name ?? 'N/A'} </b><br>
                                ${data.shipping_address ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Mobile No. </b><br>
                                ${data?.customer_phone ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Payment Method </b><br>
                                ${data?.payment_type ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Total Amount </b><br>
                                ${data.order_total_price ?? 0}
                            </div>
            
                        </div>
            
            
                        <div class="track">
                            ${ trackStatusRender(data) }
                        </div>
            
                        <hr><br><br>
                    </div>
                </article>
            </div>`;

        }else{
            html = `<div class="container-fluid">
                <article class="card">
                    <header class="card-header bg-danger text-white"> <b> My Orders / Tracking </b> </header>
                    <div class="card-body">
            
                        <div class="row">
                            <div class="col-md-2">
                                <b> Order No. </b><br>
                                ${data.order_no ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Order Date </b><br>
                                ${data.order_date ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Mobile No. </b><br>
                                ${data?.customer?.mobile_no ?? 'N/A'}
                            </div>
            
                            <div class="col-md-2">
                                <b> Total Amount </b><br>
                                ${data.order_total_price ?? 0}
                            </div>
            
                        </div>
            
            
                        <div class="track">
                            ${ trackStatusRender(data) }
                        </div>
            
                        <hr><br><br>
                    </div>
                </article>
            </div>`;
        }

        
        $('#trackOrderRow').html(html);
    }

    function openTrackModal(){
        $('#orderTrackModal').modal('show')
    }
</script>
@stack('js')

</html>