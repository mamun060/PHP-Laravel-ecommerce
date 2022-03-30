@if(isset($products) && count($products))

    <section class="container-fluid related-product-area">
        <div class="container">
            <div class="heading-title text-center">
                <h2> আমাদের অন্যান্য পণ্যসমূহ </h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product-slider">
                        <div class="slider" data-slick='{"slidesToShow": 5, "slidesToScroll": 5}'>

                            @foreach($products as $product)

                                <div class="col-md-3 px-2">
                                    <div class="card __product-card">
                                        <div class="card-wishlist {{ in_array($product->id,$wishLists) ? 'removeFromWish' : 'addToWish' }}" 
                                            data-auth="{{ auth()->user()->id ?? null }}"
                                            data-productid="{{ $product->id }}" style="z-index: 100;"
                                            type="button"> <i class="fa-solid fa-heart"></i></div>

                                            <a href="{{ route('product_detail',$product->id ) }}">
                                                <img draggable="false" src="{{asset( $product->product_thumbnail_image )}}" class="card-img-top" alt="...">
                                            </a>

                                        <div class="card-body p-0">
                                            <div class="card-product-title card-title text-center fw-bold">
                                                <a href="{{ route('product_detail',$product->id ) }}" class="text-decoration-none text-dark">
                                                    <h5>{{ $product->product_name }}</h5>
                                                </a>
                                            </div>

                                            <div class="card-product-price card-text text-center fw-bold">
                                                <h5>বর্তমান মূুল্য {{ salesPrice($product) ?? '0.0'}} /=
                                                    @if($product->product_discount)
                                                    <span class="text-decoration-line-through text-danger"> {{ number_format($product->unit_price, 2) ?? '0.0'}} /=</span>
                                                    @endif
                                                </h5>
                                            </div>

                                            <div class="card-product-button d-flex justify-content-evenly">
                                                @if($product->total_stock_qty > 0)
                                                <button type="button" data-productid="{{ $product->id }}"
                                                    class="btn btn-sm btn-secondary btn-card {{ !in_array($product->id,$productIds) ? 'addToCart' : 'alreadyInCart' }}">
                                                    {!! !in_array($product->id,$productIds) ? 'কার্ডে যুক্ত করুন' :'<span>অলরেডি যুক্ত আছে</span>' !!}</button>
                                                <a href="{{ route('checkout_index',$product->id ) }}" type="button" class="btn btn-sm btn-danger"> অর্ডার করুন </a>
                                                @else
                                                <span class="text-danger">Out of Stock</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif