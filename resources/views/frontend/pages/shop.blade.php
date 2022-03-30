@extends('frontend.layouts.master')
@section('title','Shop')

@section('content')
<!-- Product Shop Area-->
<section class="container-fluid product-shop-area my-5">
    <div class="container">
        <div class="row shop-row">

            <div class="col-md-3">
                <div class="shop-sidebar">

                    @includeIf('frontend.layouts.partials.shop_sidebar', [
                        'categories'    =>$categories ?? null, 
                        'productColor'  =>$productColors ?? null, 
                        'productSize'   =>$productSize ?? null,
                        'maxSalesPrice' => $maxSalesPrice ? $maxSalesPrice->max_sale_price : 0
                    ])

                </div>
            </div>

            <div class="col-md-9 w-100">
                @isset($products)
                <div class="row shopping-card-row" data-insert="append" data-filter-insert="html">

                    @php
                    $maxId = 0;
                    // $limit = 20;
                    @endphp

                    @foreach ($products as $item)
                        @php
                        $maxId = $item->id;
                        @endphp

                        <div class="mb-3">
                            <div class="card __product-card">
                                <div class="card-wishlist {{ in_array($item->id,$wishLists) ? 'removeFromWish' : 'addToWish' }}" data-auth="{{ auth()->user()->id ?? null }}" data-productid="{{ $item->id }}" style="z-index: 100;" type="button"> <i class="fa-solid fa-heart"></i></div>
                                <a href="{{ route('product_detail',$item->id ) }}">
                                    <img draggable="false" src="{{asset( $item->product_thumbnail_image )}}" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body p-0">
                                    <div class="card-product-title card-title text-center fw-bold">
                                        <a href="{{ route('product_detail',$item->id ) }}" class="text-decoration-none text-dark"><h5>{{ $item->product_name }}</h5></a>
                                    </div>

                                    <div class="card-product-price card-text text-center fw-bold">
                                        <h5>বর্তমান মূুল্য {{ salesPrice($item) ?? '0.0'}} /= 
                                            @if($item->product_discount)
                                            <span class="text-decoration-line-through text-danger"> {{ number_format($item->unit_price,2) ?? '0.0'}} /=</span>
                                            @endif 
                                        </h5>
                                    </div>
                                    <div class="card-product-button d-flex justify-content-evenly">
                                        @if($item->total_stock_qty > 0)
                                        <button type="button" data-productid="{{ $item->id }}" class="btn btn-sm btn-secondary btn-card {{ !in_array($item->id,$productIds) ? 'addToCart' : 'alreadyInCart' }}"> {!!  !in_array($item->id,$productIds) ? 'কার্ডে যুক্ত করুন' :'<span>অলরেডি যুক্ত আছে</span>' !!}</button>
                                        <a href="{{ route('checkout_index',$item->id ) }}?ref={{ uniqid() }}" type="button" class="btn btn-sm btn-danger"> অর্ডার করুন </a>
                                        @else 
                                        <span class="text-danger">Out of Stock</span>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        
                </div>

                <div data-totalcount="{{ $countProducts }}" data-ajax-filter="" class="text-center loadMoreContainer {{ $countProducts <= $limit ? 'd-none' : '' }} pt-5">
                    {!! loadMoreButton( route('shop_index'),$maxId, $limit) !!}
                </div>

                @endisset

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

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/common_assets/libs/jquery/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/pages/css/shop.css') }}">
@endpush

@push('js')
        <script src="{{ asset('assets/common_assets/libs/jquery/jquery-ui.min.js') }}"> </script>
        <script>
            let timeId = null;
            $(function(){
                $(document).on("change",'.category_container input[name="category"]', filterBy)

                $(document).on("click",'.color_container .color', selectColor)
                $(document).on("click",'.size_container .size', selectSize)
                $(document).on("click",'.filterTagName', selectTag)
    
                $(document).on("click",'.parentCategory', toggleChildrenCategories)
    
                $(document).on("click",'.stateChange', incrementDecrementCount)
        
                        
                // ============Range Slider ================== 
                
                    $("#slider-range").slider({
                        range: true, 
                        min: 0,
                        max:  $("#max-price").data('max'),
                        step: 5,
                        slide: function( event, ui ) {
                            $( "#min-price").html(ui.values[ 0 ]);
                            suffix = '';
                            if (ui.values[ 1 ] == $( "#max-price").data('max') ){
                                suffix = ' +';
                            }
                            // console.log(ui.values[1], suffix)
                            $( "#max-price").html(ui.values[ 1 ] + suffix);   
                            
                            filterBy();
                        }
                    })
    
                // ============slider ================== 
        
            });


            function selectColor(){
                let 
                currentElem = $(this);
                currentElem.toggleClass('selected')

                filterBy();

                // updateSelectedStatus();
            }

            function selectSize(){
                let 
                currentElem = $(this);
                currentElem.toggleClass('selected');
                filterBy();
            }

            function selectTag(){
                let 
                currentElem = $(this);
                currentElem.toggleClass('selected');
                filterBy();
            }

        
            function toggleChildrenCategories(){
                let 
                elem    = $(this),
                current = elem.attr('data-category'),
                target  = $(`.childer-category[data-parent=${current}]`),
                icon    = elem.find('.triggerIcon');
                target.toggle();
    
                if(icon.hasClass('fa-angle-down')){
                    icon.removeClass('fa-angle-down')
                    icon.addClass('fa-angle-up')
                }else{
                    icon.removeClass('fa-angle-up')
                    icon.addClass('fa-angle-down')
                }
            }
    
    
            function incrementDecrementCount(e){
                let 
                countElem   = $('#count'),
                count       = Number(countElem.text() ?? 0 ),
                elem        = $(this),
                ref         = elem.attr('id'),
                pattern1    = /(plus|increment|increament)/im,
                pattern2    = /(minus|decrement|decreament)/im,
                minCount    = Number(countElem?.attr('data-min') ?? 1),
                maxCount    = Number(countElem?.attr('data-max') ?? 10);
    
                if(pattern1.test(ref)){
    
                    count++;
                    if(count > maxCount) count = maxCount;
    
                }else if(pattern2.test(ref)){
    
                    count--;
                    if(count < minCount) count = minCount;
                }
    
                countElem.text(count);
            }


            function filterBy(){

                let 
                category_ids= [],
                colors      = [],
                sizes       = [],
                prices      = null,
                tags        = [],
                filterObj   = {};

                clearTimeout(timeId)

                timeId = setTimeout(() => {
                    let categories    = $(document).find('input[name="category"]:checked');
                    let colorElems    = $(document).find('.color_container .color.selected');
                    let sizeElems     = $(document).find('.size_container .size.selected');
                    let tagElems      = $(document).find('.filterTagName.selected');
                    let minPrice      =  $('#min-price').text();
                    let maxPrice      =  $('#max-price').text();

                    categories.map((i, cat) => {
                        category_ids.push($(cat).val());
                    })

                    colorElems.map((i, color) => {
                        colors.push($(color).attr('data-color'));
                    })

                    sizeElems.map((i, size) => {
                        sizes.push($(size).attr('data-size'));
                    })

                    prices = {
                        minPrice,
                        maxPrice
                    };

                    tagElems.map((i, tag) => {
                        tags.push($(tag).attr('data-tag'));
                    })
                    
                    filterObj = {
                        category_ids: category_ids,
                        colors      : colors,
                        sizes       :  sizes,
                        prices      : prices,
                        tags        : tags
                    };

                    console.log(filterObj); 
                    shop_ajax_filter(filterObj);
                }, 500);
            }



            function shop_ajax_filter(filterObj){

                let 
                elemContainer   = $('.loadMoreContainer'),
                elem            = $('.loadMoreBtn'),
                max_id          = elem.attr('data-maxid'),
                limit           = elem.attr('data-limit'),
                method          = 'POST',
                dataInsertElem  = $(document).find('[data-filter-insert]');
                dataInsert      = dataInsertElem.data('filter-insert');

                elem.attr('data-ajax-filter', '');
                
                ajaxFormToken();

                $.ajax({
                    url     : APP_URL + '/shop',
                    type    : method,
                    data    : filterObj,
                    cache   : false,
                    success : function (res) {
                        // console.log(res, res?.max_id);
                        elem.attr('data-maxid', res?.max_id);

                        elemContainer.attr('data-totalcount', Number(res?.totalCount));

                        if(res?.html != null){

                            elem.attr('data-ajax-filter', true);

                            if (res?.isLast || Number(res?.totalCount) <= Number(limit)) {
                                elemContainer.addClass('d-none');
                            }else{
                                elemContainer.removeClass('d-none');
                            }
                            
                            // console.log(dataInsertElem, dataInsert);
                            if (dataInsertElem.length){
                                dataInsertElem[dataInsert](res.html);
                            }

                            // data-ajax=true

                        }
                    },
                    error: function (error) {
                        console.log(error);
                        elem.attr('data-ajax-filter', '');
                    }
                });

            }

                
        </script>
@endpush