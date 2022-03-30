<!-- Top Header-->
<section class="container-fluid top-header">

    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <h2 class="hotline"> হট লাইন- <a href="tel:01971819813" type="button">০১৯৭-১৮১৯-৮১৩</a></h2>
            </div>

            <div class="col-md-6 d-flex align-items-center justify-content-lg-end justify-content-center">
                @guest
                    <div class="register-button bg-white btn-group" role="group">
                        <a href="{{ route('login') }}" class="btn btn-sm active"> লগ ইন </a>
                        <a href="{{ route('register') }}" class="btn btn-sm "> রেজিস্টার </a>
                    </div>
                @else 
                <div class="mx-2" style="margin-top: -8px">
                    @php
                        $path = auth()->user()->profile ? auth()->user()->profile->photo : null;
                    @endphp
                    <a class="text-decoration-none text-dark" href="{{ route('dashboard.index') }}">
                      {!! profilePhoto($path,['class' => 'img-fluid rounded-circle', 'width' => '30px', 'draggable' => 'false'] ) !!}
                    </a>
                </div>
                <h6><a class="text-decoration-none text-dark" href="{{ route('dashboard.index') }}">{{ auth()->user()->name ?? 'N/A' }}</a></h6>
                @endguest
            </div>

        </div>
    </div>

</section>
