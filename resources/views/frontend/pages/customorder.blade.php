@extends('frontend.layouts.master')
@section('title','Custom Order')

@section('content')
<!-- Single Product Area-->
    <section class="container-fluid custom-product-area my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    @isset($customServiceProduct)
                        <div class="custom-prodect-image-wrapper">
                            <img src="{{asset($customServiceProduct->product_thumbnail)}}" alt="custom product images">
                            {{-- <img src="{{asset('assets/frontend/img/product/Rectangle 98.png')}}" alt="custom product images"> --}}
                        </div>
                    @endisset
                </div>
                <div class="col-md-6">
                    <div class="custom-prodect-info">
    
                        <div class="single-prodect-title">
                            <h2> টি সার্ট </h2>
                        </div>
    
                        <div class="single-prodect-description">
                            <p>
                                যে কোনো ধরনের কাস্টমাইজড প্রোডাক্ট সামগ্রী তৈরি করতে সর্বনিম্ন খরচে, দ্রুততম সময়ে, সর্বোচ্চ
                                গুণগত মানের নিশ্চয়তা পাবেন কেবল মাইক্রোমিডিয়ায়।
                            </p>
                        </div>
    
                        <div class="custom-prodect-form">
                            {{-- @dd($customServiceProduct) --}}
                            <input type="hidden" name="product_id" id="product_id" value="{{$customServiceProduct->id}}">
                            <input type="hidden" name="product_name" id="product_name" value="{{ $customServiceProduct->product_name}}">
                            <div class="form-group">
                                <label for="customerName"> আপনার নাম </label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control form-control2 border"
                                    id="customerName" placeholder=" আপনার নাম ">
                            </div>
                            <div class="form-group">
                                <label for="customerPhone"> মোবাইল নাম্বার </label>
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control form-control2 border"
                                    id="customerPhone" placeholder=" মোবাইল নাম্বার  ">
                            </div>
    
                            <div class="form-group">
                                <label for="customerAddress"> আপনার ঠিকানা </label>
                                <textarea style="resize: none;" name="customer_address" id="customer_address" class="form-control border"
                                    id="customerAddress" rows="20" cols="10"
                                    placeholder=" আপনি কি চাচ্ছেন তা উল্লেখ করুন.... "></textarea>
                            </div>
    
                            <div class="button-area form-group row justify-content-between align-items-center my-4">
                                <div class="col-md-7 mx-0 px-0">
                                    <input type="file" name="logo" id="customLogo" class="d-none">
                                    <button class="btn btn-light text-danger w-100"
                                        onclick="javascript: document.getElementById('customLogo').click()">
                                        <span class="fa-solid fa-images"></span><span id="fileCount" class="mx-1">লোগো এ্যাড করতে এখানে ক্লিক করুন</span>
                                    </button>
                                </div>
                                <div class="col-md-5 mx-0 px-0 d-flex justify-content-end">
                                    <button id="submit_to_order" class="btn btn-danger text-white w-custom-95">কনফার্ম করুন</button>
                                </div>
                            </div>
                        </div>
    
                        {{-- @dd($contactInfo) --}}
                        <div class="contact-info row">
                            <h6 class="mt-4 mb-2">আমাদের সাথে সরাসরি যুক্ত হোন</h6>
                            <div class="contact-inner-info col-md-12">
                                {{-- @dd($contactInfo) --}}
                               @if ($contactInfo)
                                    @if($contactInfo->fb_messenger)
                                        <span><a target="_blank" href="{{ $contactInfo->fb_messenger }}"><i class="fab fa-whatsapp"></i></a></span>
                                        {{-- <span><i class="fa fa-phone"></i> <span><a href="tel:{{$contactInfo->phone}}">{{$contactInfo->phone}}</a></span></span> --}}
                                    @endif
                                    @if($contactInfo->whatsapp)
                                        <span><span><a target="_blank" href="{{$contactInfo->whatsapp}}"><i class="fab fa-facebook-messenger"></i></a></span></span>
                                        {{-- <span><i class="fa fa-envelope"></i> <span><a href="mailto:{{$contactInfo->email}}">{{$contactInfo->email}}</a></span></span> --}}
                                    @endif
                               @endif
                            </div>
                        </div>
    
    
    
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- Related Product Area-->


    @includeIf('frontend.layouts.partials.other_product', ['products' => $otherProducts ?? null ])
    
    <!-- Our Contact Area-->
    <section class="container-fluid call-center-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex align-items-center justify-content-center">
                    <div class="call-center text-center">
                        <h2> আপনি যা খুঁজছিলেন তা খুঁজে পাননি? কল করুন:<span> <a href="tel:01971819813" class="text-decoration-none" type="button">০১৯৭-১৮১৯-৮১৩</a></span></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/slick-carousel/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/slick-carousel/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/pages/css/customorder.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/frontend/libs/slick-carousel/slick.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/config.js') }}"></script>
    <script>

        let timeId = null;
        $(function(){    
    
        // ============slider ================== 
            $('.product-slider .slider').slick({
                dots: true,
                infinite: false,
                speed: 500,
                slidesToShow: 5,
                slidesToScroll: 5,
                // centerMode: true,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        // ============slider ================== 


        });

        $(document).ready(function(){
            $(document).on('click' , '#submit_to_order', submitToDatabase)
            $(document).on('change' , '#customLogo', countUploadedLogo)
        });

        function submitToDatabase(){

            ajaxFormToken()

            clearTimeout(timeId)
            let uplodedFile = fileReader($('#customLogo'));
            timeId = setTimeout(() => {
                let obj = {
                    url     : `{{ route('customize.store') }}`,
                    method  : "POST",
                    data    : { ...formatData(), order_attachment: JSON.stringify(uplodedFile) },
                };

                ajaxRequest(obj, { reload: true, timer: 1000 })

                resetForm();
            }, 500);
            
        }

        function formatData(){
            return {
                customer_name       : $('#customer_name').val(),
                customer_phone      : $('#customer_phone').val(),
                customer_address    : $('#customer_address').val().trim(),
                _token              : `{{ csrf_token()}}`,
                custom_service_product_id: $('#product_id').val(),
                custom_service_product_name: $('#product_name').val(),
                order_attachment: null
            }
            
        }


        function resetForm(){
            $('#customer_name').val('');
            $('#customer_phone').val('');
            $('#customer_address').val('');
        }


        function fileReader(elem){

            let file = [];
            if(elem[0].files && elem[0].files[0]){
                //customLogo
                let FR = new FileReader();
                FR.addEventListener("load", function (e) {
                    file.push(e.target.result);
                });

                FR.readAsDataURL(elem[0].files[0]);

                return file;
            }
            
        }


        function countUploadedLogo(e){

            if(!e.target.files?.length){
                $('#fileCount').text('লোগো এ্যাড করতে এখানে ক্লিক করুন')
                return false;
            }

            $('#fileCount').text('লোগোটি সফলভাবে এ্যাড হয়েছে')

        }
            
    </script>
@endpush