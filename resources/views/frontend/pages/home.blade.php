@extends('frontend.layouts.master',  ['customservicecategories'=>$customservicecategories ?? null, 'sociallink'=>$sociallink ?? null, 'footerabout'=>$footerabout ?? null])
@section('title','Home')

@section('content')
    <!-- Hero Area-->
    <section class="container-fluid hero-area">
    
        <div class="background-1">
            <img src="{{asset('assets/frontend/img/bg/bg-1.png')}}" alt="bg-1">
        </div>
    
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
    
                    <div class="hero-content">
                        <div class="hero-heading">
                            <h2>আপনি কি তৈরী করতে চান ?</h2>
                        </div>
                        <div class="hero-text">
                            <p>যে কোনো ধরনের কাস্টমাইজড প্রোডাক্ট সামগ্রী তৈরি করতে সর্বনিম্ন খরচে, দ্রুততম সময়ে, সর্বোচ্চ
                                গুণগত মানের নিশ্চয়তা পাবেন কেবল মাইক্রোমিডিয়ায়। আপনার চাহিদা অনুযায়ী যে কোনো ধরনে কাস্টমাইজড
                                প্রিন্টের কাজের অর্ডার করুন নিচের লিস্ট থেকে </p>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    
    </section>
    
    <!-- Product Area-->
    <section class="container-fluid product-area">
    
        <div class="container">
            <div class="row">
                @php
                    $maxCatId = 0;
                @endphp

                @isset($customservicecategories)
                    @foreach ($customservicecategories as $customservicecategory)
                        @php
                        $maxCatId = $customservicecategory->id;
                        @endphp

                        <div class="col-md-4 col-sm-12 mb-4">
                            <div class="product-content d-flex">
        
                                <div class='reveal'>
                                    <div class="image-wrap">
                                        <div class="product-img">
                                            @isset($customservicecategory->category_thumbnail)
                                                <img src="{{asset( $customservicecategory->category_thumbnail )}}" alt="Product img">
                                            @else    
                                                <img src="{{asset('assets/frontend/img/product/1234.png')}}" alt="Product img">
                                            @endisset
                                        </div>
                                    </div>
                                </div>
            
                                <div class="product-details text-center">
                                    <h3 class="product-title"> {{ $customservicecategory->category_name  }} </h3>
                                    <p class="product-text">  {{ $customservicecategory->category_description  }} </p>
                                    <a href="javascript:void(0)" id="category_id" data-categoryid="{{$customservicecategory->id}}" type="button" class="product-button customize-btn"> কাস্টমাইজ করুন </a>
                                </div>
            
                            </div>
                        </div>
                    @endforeach
                @endisset
    
                <div data-totalcount="{{ $countCustomservicecategories ?? 0 }}" class="product-ses-more text-center loadMoreContainer {{ $countCustomservicecategories <= $limit ? 'd-none' : '' }}">
                    <a href="javascript:void(0)" data-uri="{{ route('home_index') }}" class="loadMoreBtn" data-maxid="{{ $maxCatId }}" data-limit="{{ $limit }}"> আরও কাস্টমাইজ প্রোডাক্ট দেখুন </a>
                </div>
    
            </div>
        </div>
    
    </section>
    
    <!-- Readymade Products Area-->
    <section class="container-fluid readymade-products-area">
    
        <div class="background-2">
            <img src="{{asset('assets/frontend/img/bg/bg-2.png')}}" alt="bg-1">
        </div>
    
        <div class="container">
    
            <div class="heading-title text-center">
                <h2>রেডিমেট প্রডাক্ট কিনুন</h2>
            </div>
    
            <div class="row">
                <div class="readymade-products-content">
                    <div class="readymade-products">
                        @if($shopbanner && $shopbanner->banner_image)
                                <a href="{{ route('shop_index')}}"><img src="{{ asset($shopbanner->banner_image) }}" class="img-fluid" alt="micromedia-image"></a>
                            @else 
                                <a href="{{ route('shop_index')}}"><img src="{{asset('assets/frontend/img/micromedia-image 1.png')}}" class="img-fluid" alt="micromedia-image"></a>
                        @endif
                    </div>
                </div>
            </div>
    
        </div>
    
    </section>
    
    <!-- Our Service Area-->
    <section class="container-fluid our-service-area">
    
        <div class="background-3">
            <img src="{{asset('assets/frontend/img/bg/bg-3.png')}}" alt="bg-3">
        </div>
    
        <div class="container">
    
            <div class="heading-title text-center">
                <h2> আমাদের সার্ভিস সমূহ </h2>
            </div>
    
            <div class="row">
                @isset($customservices)
                    @foreach ($customservices as $customservice)
                        <div class="col-md-3 col-12 mt-4 d-flex align-items-center justify-content-center">
                            <div class="card service-card">
                                <img draggable="false" class="card-img-top" src="{{ asset($customservice->service_thumbnail) }}" alt="Card image cap">
                                @if ($customservice->is_allow_caption)
                                    <div class="card-body">
                                        <p class="card-text text-center">{{ $customservice->service_name  }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endisset
    
            </div>
    
        </div>
    
    </section>
    
    <!-- Our Clients Area-->
    <section class="container-fluid our-clients-area">
    
        <div class="container">
    
            <div class="heading-title text-center">
                <h2> আমাদের ক্লাইন্টসমূহ </h2>
            </div>
    
            <div class="client-details">
                <div class="row d-flex align-items-center justify-content-center loadMoreContainerlogosparent">

                    @php
                        $maxClientLogoId = 0;
                    @endphp

                    @isset($clientlogos)
                        @foreach ($clientlogos as $clientlogo)
                            @php
                            $maxClientLogoId = $clientlogo->id;
                            @endphp

                            @if($clientlogo->logo)
                            <div class="col-md-2">
                                <div class="single-client text-center m-1">
                                    <img src="{{asset( $clientlogo->logo ?? null)}}" alt="">
                                </div>
                            </div>
                            @endif 

                        @endforeach
                    @endisset
                </div>
            </div>

            <div data-totalcount="{{ $countClientLogos ?? 0 }}"
                class="product-ses-more text-center loadMoreContainerlogos {{ $countClientLogos <= $clientLogosLimit ? 'd-none' : '' }}">
                <a href="javascript:void(0)" data-uri="{{ route('home_client_loadmore') }}" class="loadMoreBtnClientLogo" data-maxid="{{ $maxClientLogoId }}"
                    data-limit="{{ $clientLogosLimit }}"> আরও ক্লাইন্ট দেখুন </a>
            </div>
    
        </div>
    
    </section>
    
    <!-- Our Contact Area-->
    <section class="container-fluid our-contact-area">
    
        <div class="container">
    
            <div class="heading-title text-center">
                <h2> আমাদের আবাসন </h2>
            </div>
    
            <div class="contact-details">
                <div class="row d-flex align-items-center justify-content-center">
    
                    <div class="col-md-7 mt-3">
                        <div class="google-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.696488940541!2d90.41667951445731!3d23.829389491672313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c759240dcc93%3A0x87a7975c20b12087!2sThemeShaper!5e0!3m2!1sen!2sbd!4v1646046001517!5m2!1sen!2sbd"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
    
                    <div class="col-md-5 mt-3">
    
                        <div class="contact-form">
                            <h3 class="text-center">যোগাযোগ করুন </h3>

                                <div class="form-group form-group2">
                                    <input type="text" class="form-control form-control2 border mt-3"
                                        id="name" placeholder=" আপনার নাম ">
                                </div>
    
                                <div class="form-group">
                                    <input type="email" class="form-control form-control2 border mt-3"
                                        id="email" placeholder=" ইমেইল অ্যাড্রেস ">
                                </div>
    
                                <div class="form-group">
                                    <input type="number" class="form-control form-control2 border mt-3"
                                        id="phone" placeholder=" ফোন নাম্বার ">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control form-control2 border mt-3"
                                        id="subject" placeholder="সাবজেক্ট">
                                </div>
    
                                <div class="form-group">
                                    <textarea style="resize: none;" class="form-control border mt-3"
                                        id="message" rows="20" cols="10"
                                        placeholder=" আপনি কি চাচ্ছেন তা উল্লেখ করুন.... "></textarea>
                                </div>
    
                                <div class="form-group text-center text-lg-end  mt-3">
                                    <button class="contact-button btn-outline-none border-0" id="contact_sent_btn"> পাঠিয়ে দিন </button>
                                </div>
    
                        </div>
    
                    </div>
    
                </div>
    
            </div>
    
        </div>
    
    </section>
    
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
    
    
    <!-- ------------------ modal -------------------  -->
    
    <div class="modal fade" style="z-index: 22001;" id="customProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-dialog-scrollable">
    
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel "> আপনার পছন্দের টি-শার্ট নির্ধারণ করুন! </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body">
    
                    <div class="grid-product-container"> </div>
    
    
                </div>
    
            </div>
        </div>
    </div>
    
    
    
    <!-- ------------------ modal -------------------  -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/pages/css/home.css') }}">
    <style>
        /*   img {
             height: 100%;
             width: auto;
             max-width: 75vw;
             object-fit: contain;
           }*/
   
           .image-wrap {
             transition: 1s ease-out;
             transition-delay: 0.1s;
             position: relative;
             /*width: auto;
             height: 80vh;*/
             overflow: hidden;
             clip-path: polygon(0 100%, 100% 100%, 100% 100%, 0 100%);
             visibility: hidden;
           }
   
           .image-wrap img {
             transform: scale(1.2);
             transition: 2s ease-out;
           }
   
           .animating .image-wrap {
             clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
             visibility: visible;
             transform: skewY(0);
           }
   
           .animating img {
             transform: scale(1);
             transition: 2s ease-out;
           }
   
           .fadeup {
             opacity: 0;
             transition: 0.2s ease-out;
             transform: translateY(40px);
           }
   
           .fading-up {
             opacity: 1;
             transition: 1s ease-out;
             transform: translateY(0px);
             transition-delay: 0.4s;
           }

        .reveal.animating {
            margin-top: -62px;
        }
          
       </style>
@endpush

@push('js')
<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
        const options = {
        root: null,
        rootMargin: "0px",
        threshold: 0.4
        };

        // IMAGE ANIMATION

        let revealCallback = (entries) => {
        entries.forEach((entry) => {
            let container = entry.target;

            if (entry.isIntersecting) {
            console.log(container);
            container.classList.add("animating");
            return;
            }

            if (entry.boundingClientRect.top > 0) {
            container.classList.remove("animating");
            }
        });
        };

        let revealObserver = new IntersectionObserver(revealCallback, options);

        document.querySelectorAll(".reveal").forEach((reveal) => {
        revealObserver.observe(reveal);
        });

    });
</script>

<script>
    $(document).ready( function(){
        $(document).on('click', '.customize-btn', loadCustomizeProduct)
        $(document).on('click', '.customize-product-box', loadCustomizeProductPage)
        $(document).on('click','#contact_sent_btn', submitToDatabase)
        $(document).on('click','.loadMoreBtnClientLogo', loadMoreLogos)
    });

    function loadCustomizeProduct(){
        let 
        elem        = $(this),
        category_id = elem.attr('data-categoryid'); 

        $.ajax({
            url     : `{{ route('customize.getCustomizeProduct','')}}/${category_id}`,
            method  : 'GET',
            beforeSend(){
                console.log('sending ...');
            },
            success(data){
                console.log(data);
                let 
                cssStyle = '',
                products = ``;
                if(data.length){
                    data.forEach(item => {
                        let productImage = item?.product_thumbnail ?? 'assets/frontend/img/product/product-1.png';
                        products += `<div class="card-box customize-product-box" data-href="${window.location.origin}/customize/custom-order/${item.id}">
                            <div class="card modal-card text-center">
                                <img class="pt-3" src="${window.location.origin}/${productImage}" alt="Product Image">
                                <p> ${item?.product_name ?? 'N/A'} </p>
                            </div>
                        </div>`;
                    });
                    cssStyle = ['grid-template-columns','repeat(auto-fill, minmax(160px, 1fr))'];
                }else{
                    products += `<div class="row">
                        <div class="alert alert-danger my-3">
                            <h4>404</h4>
                            <p>Oops! No Product Found For The category!</p>
                        </div>
                    </div>`;

                    cssStyle = ['grid-template-columns','repeat(1, 1fr)'];
                }

                $('.grid-product-container').html(products)
                $('.grid-product-container').css(cssStyle[0],cssStyle[1]);
                $('#customProductModal').modal('show')
            }
        });
    }

    function loadCustomizeProductPage(){
        let elem = $(this);
        $(document).find('.customize-product-box').find('.modal-card').removeClass('active')
        elem.find('.modal-card').addClass('active')

        setTimeout(() => {
            window.open(elem.attr('data-href'),"_self");
        }, 1000);
    }

    function submitToDatabase(){
        let obj = {
            url     : `{{ route('contact_store')}}`, 
            method  : "POST",
            data    : formatData(),
        };

        ajaxRequest(obj, { reload: true, timer: 2000 })
    }

    function formatData(){
        return {
            name    : $('#name').val().trim(),
            email   : $('#email').val(),
            phone   : $('#phone').val(),
            subject : $('#subject').val().trim(),
            message : $('#message').val().trim(),
            _token  : `{{csrf_token()}}`
        }
    }

</script>
@endpush