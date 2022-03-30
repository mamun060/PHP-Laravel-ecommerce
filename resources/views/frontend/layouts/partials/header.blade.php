<!-- Main Header-->
<header class="container-fluid main-header box-shadow">

    <nav class="navbar navbar-expand-lg navbar-light">

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="logo" src="{{asset('assets/frontend/img/logo-mic.png')}}" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="{{ route('home_index') }}"> কাস্টমাইজ </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop_index') }}"> শপ </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gallery_index') }}"> গ্যালারী </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about_index') }}"> আমাদের সম্পর্কে </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact_index') }}"> যোগাযোগ </a>
                    </li>
                </ul>

                <form action="{{ route('searchResult') }}" autocomplete="off" class="d-flex justify-content-lg-end justify-content-start" style="position: relative !important;">
                    <div class="input-group border rounded">
                        <input class="form-control search-product" name="key" type="search" placeholder=" অনুসন্ধান করুন " aria-label="Search">
                        <button class="btn d-flex justify-content-center" type="submit"><i
                                class="fas fa-search"></i></button>
                    </div>
                    <div id="my-list"></div>
                </form>

                <div class="ordertraking">
                    <a href="javascript:void(0)"> <i class="fa-solid fa-truck-fast text-light"></i> অর্ডার ট্রাক করুন </a>
                </div>

                <div class="cart-icon">
                    <a href="{{ route('cart_index') }}"> <i class="fas fa-cart-shopping"></i><span class="cartvalue"> {{ isset($productIds) && is_array($productIds) ? count($productIds) : 0 }} </span></a>
                </div>

            </div>
        </div>

    </nav>

</header>
