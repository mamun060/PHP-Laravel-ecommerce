@extends('frontend.layouts.master')
@section('title','About')

@section('content')
 
<!-- about section starts  -->

<section class="about my-5" id="about">

    <div class="heading-title text-center text-danger">
        <h2 class="fw-bold"> আমাদের সম্পর্কে </h2>
    </div>

    <div class="container">

        <div class="row pt-5">

            @if($aboutData)
                <div class="col-md-6 left">
                    <div class="content">
                        <h2 class="mb-4"> {{ $aboutData ? $aboutData->about_title :  ''}}</h2>
                        <p> {{ $aboutData ? $aboutData->about_description : ''}} 
                        </p>
                    </div>
                </div>

                <div class="col-md-6 right">
                    <div class="image">
                        @if ($aboutData->about_thumbnail)
                            <img draggable="false" src="{{ asset( $aboutData->about_thumbnail) }}" alt="About Img">
                        @else
                            <img draggable="false" src="{{ asset('assets/frontend/img/about/about-us.jpg') }}" alt="About Img">
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>

</section>

<!-- about section ends -->



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
    <link rel="stylesheet" href="{{ asset('assets/frontend/pages/css/about.css') }}">
@endpush