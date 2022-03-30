<!-- Footer Area-->
<footer class="container-fluid">

    <div class="container">
        <div class="row py-4">

            <div class="col-md-3">

                <div class="about-footer">
                    {{-- @dd($footerabout) --}}
                    @if($footerabout)

                        @if($footerabout->footer_logo)
                            <div class="footer-logo my-3">
                                <a href="{{ url('/') }}"><img class="logo" src="{{asset($footerabout->footer_logo)}}" alt="footer logo"></a>
                            </div>
                        @endif

                        @if($footerabout->footer_about)
                            <div class="footer-text">
                                <h2>{{ $footerabout->footer_about }}</h2>
                            </div>
                        @endif

                    @endif

                    {{-- @dd($sociallink) --}}
                    @if($sociallink)
                        <div class="footer-social">
                            @if( $sociallink->facebook )
                                <a href="{{ $sociallink->facebook }}"><i class="fa-brands fa-facebook"></i></a>
                            @endif

                            @if( $sociallink->twitter )
                                <a href="{{ $sociallink->twitter }}"><i class="fa-brands fa-twitter"></i></a>
                            @endif

                            @if( $sociallink->instagram )
                                <a href="{{ $sociallink->instagram }}"><i class="fa-brands fa-instagram"></i></a> 
                            @endif

                            @if( $sociallink->linkedin )
                                <a href="{{ $sociallink->linkedin }}"><i class="fa-brands fa-linkedin"></i></a> 
                            @endif

                        </div>
                    @endif

                </div>
            </div>

            <div class="col-md-3">

                <div class="footer-text-header">
                    <h3> কাস্টমাইজ </h3>
                </div>

                {{-- @dd($customservicecategories) category_name --}}
                <div class="category-menu">
                    <ul class="list-unstyled">
                        @isset($customservicecategories)
                            @foreach ( $customservicecategories as $customservicecategory )
                                <li><a href="javascript:void(0)" class="customize-btn" data-categoryid="{{ $customservicecategory->id }}">{{ $customservicecategory->category_name }}</a></li>
                            @endforeach
                        @endisset
                        {{-- <li><a href=""> টি-সার্ট </a></li>
                        <li><a href=""> পোলো টি-সার্ট </a></li>
                        <li><a href=""> চাবির রিং </a></li>
                        <li><a href=""> ক্যাপ </a></li>
                        <li><a href=""> মাস্ক </a></li>
                        <li><a href=""> ছাতা </a></li>
                        <li><a href=""> মগ </a></li>
                        <li><a href=""> এ্যাক্রিলিক প্রিংট </a> </li>
                        <li><a href=""> এসোসিরিজ </a></li>
                        <li><a href=""> শপিং ব্যাগ </a></li>
                        <li><a href=""> জ্যারসি</a></li>
                        <li><a href=""> ছাতা </a></li>
                        <li><a href=""> ক্রিস্ট </a></li> --}}

                    </ul>
                </div>

            </div>

            <div class="col-md-3">

                <div class="footer-text-header">
                    <h3> মেনু </h3>
                </div>

                <div class="footer-menu">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about_index')}}"> আমাদের সম্পর্কে</a></li>
                        <li><a href="{{ route('contact_index')}}"> যোগাযোগ করুন </a></li>
                        <li class="ordertraking-footer
                        "><a href="javascript:void(0)"> অর্ডার ট্র্যাক করুন </a></li>
                        <li><a href="{{ route('dashboard.index')}}"> একাউন্ট </a></li>
                    </ul>
                </div>
             
            </div>

            <div class="col-md-3">

                <div class="footer-text-header">
                    <h3>আমাদের অংগ প্রতিষ্ঠান সমূহ</h3>
                </div>

                <div class="our-organigation">
                    <ul class="list-unstyled d-flex">
                        <li><a href=""><img class="img-fluid" src="{{asset('assets/frontend/img/footer/footer-1.png')}}" alt=""></a></li>
                        <li><a href=""><img class="img-fluid" src="{{asset('assets/frontend/img/footer/footer-2.png')}}" alt=""></a></li>
                    </ul>
                </div>

                {{-- @dd($contactInfo) --}}
                @if($contactInfo)
                    <div class="footer-address">
                        @if ( $contactInfo->address )
                            <p>{{ $contactInfo->address }}</p>
                        @endif
                    </div>
                @endif

            </div>

        </div>
        <div class="row order-top-color pt-2">

            <div class="col-md-6">
                <div class="copy-right-footer">
                    <p> কপিরাইট © ২০২২ মাইক্রোমিডিয়া. সমস্ত অধিকার সংরক্ষিত. </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="footer-privacy-policy">
                    <ul class="list-unstyled d-flex justify-content-end align-items-start align-items-lg-center flex-column flex-lg-row ">
                        <li><a href="#"> প্রাইভেসি এন্ড পলিসি </a></li>
                        <li><a href="#"> টার্মস এন্ড কন্ডিশন </a></li>
                        <li><a href="#"> সাইটম্যাপ </a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>

