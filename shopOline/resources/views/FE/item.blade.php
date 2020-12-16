@extends('layouts.theme')
@section('title',"$slug_product")

@section('css')
    {{-- style item --}}
    <link href="{{ asset('css/front-end/item.css') }}" rel="stylesheet">
@endsection
@section('style') 
	<style>
		#shop .active{
			background: white;
			height: 2px;
			width: 100%;
			transition: 1s;
		}
	</style>
@endsection
@section('content')
    {{-- breadcrumb --}}
    {{-- <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: none;">
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ asset('/shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active">item</li>
                </ol>
                </nav>
            </div>
        </div>
    </div> --}}

    {{-- gallery --}}
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-lg-7 col-md-6 ">
                <div class="row">
                    <div class="col-lg-2 gallery">
                       
                        @foreach($images as  $value)
                            <div class="item">
                                <img src="{{ $value->image }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-10">
                        <div class="owl-carousel owl-theme detail-item">
                            @foreach($images as  $value)
                                <div class="item">
                                    <img src="{{ $value->image }}" alt="">
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 detail-info">
                
                @foreach($product as  $value)
                    <form action="{{ asset('cart/add') }}/{{$value->id_product}}" method="POST" style="width: 70%">
                        @csrf
                        <p style="text-transform: uppercase">
                            <b> 
                                {{ $value->name_product }} {{-- NAME PRODUCT --}}
                            </b>
                        </p> 
                        <p> 
                            {{ number_format($value->price1,0,',','.') }} ₫ {{-- PRICE PRODUCT --}}
                        </p> 
                        
                        <select name="color" id="color" class="form-control" required> {{-- COLOR --}}
                            @foreach($colors as $key =>  $color)
                                @if($value->id_product == $color->id_product )
                                    <option value="{{ $color->id_color }}">
                                        {{ $color->color }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <select name="size" id="size" class="form-control" required></select>   {{-- SIZE --}}

                        <div class="quantity" style="margin-bottom: 20px;">
                            <span class="input-number-decrement down">–</span>
                            <input class="input-number" type="number" value="1" min="1" max="" readonly name="quantity">
                            <span class="input-number-increment up">+</span>
                        </div>

                        <input type="hidden" name="namep"  value="{{ $value->name_product }}">
                        <input type="hidden" name="pricep"  value="{{ $value->price1 }}">
                        <input type="hidden" id="pro" name="id-pro"  value="{{ $value->id_product }}">
                        <input type="hidden" name="slug" value="{{ $slug_product }}">

                        <button class="btn-1 hvr-bounce-to-right" type="submit" >
                            THÊM VÀO GIỎ
                        </button>
                        <button class="btn-2 hvr-bounce-to-right" type="submit" >
                            <a href="{{ asset('cart') }}">
                                MUA NGAY
                            </a>
                        </button>
                    </form> 

                    <div class="info">
                        <ul>
                            @php
                                echo $value->description
                            @endphp
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="row">
                <h2 style="text-align: center;width: 100%;font-weight: bold;margin:50px 0;">SẢN PHẨM LIÊN QUAN</h2>
                <div class="col-lg-12" style="padding: 0">
                    <div class="owl-carousel owl-theme related_products new-product">
                        @foreach($related_products as $value)
                            <div class="item">
                                <div class="img-product">
                                    <?php
                                        $ds1 = [];		
                                    ?>
                                    @foreach($image as $img)
                                        @if($value->id_product == $img->id_product)
                                            <?php
                                                array_push($ds1, $img->image);
                                            ?>
                                        @endif
                                    @endforeach

                                    <a href="{{ asset('shop') }}/{{ $value->slug_product }}" title="">
                                        <div class="front">
                                            <img src="{{ $ds1[0] }}">
                                        </div>

                                        <div class="back">
                                            <img src="{{ $ds1[1] }}">
                                        </div>
                                    </a>
                                </div>
                                <div class="info">
                                    <br>
                                    <span>{{ $value->name_product }}</span>
                                    <span>{{ number_format($value->price1 ,0, ',', '.') }} đ</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
   
    <p id="num" class="hide"></p>
    <form action="" id="a"></form>
@endsection


@section('js')

    <script>
        $(document).ready(function(){
            getSize();
            getNum();
            
            $("select[name='color']").change(function(){
                getSize();
                getNum();
                $('.input-number').val('1');
            });

            $("select[name='size']").change(function(){
                getNum();
                $('.input-number').val('1');
            });
        });

        function getSize(){
            var color_id = $('#color').val();
            var pro = $('#pro').val();
            $.ajax({
                url: '{{ asset("/shop/get/size/") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async:false,
                method: "post",
                dataType: "json",
                data: {
                    color_id: color_id,
                    pro: pro
                },
                success: function(data) {
                    
                    $("select[name='size']").html('');
                    $.each(data, function(key, value){
                        $("select[name='size']").append(
                            "<option value=" + value.id_size + ">" + value.size + "</option>"
                        );
                    });

                },error:function(){ 
                    $('#a').submit();
                }
            });
        };

        function getNum(){
            var color_id = $('#color').val();
            var size= $('#size').val();
            var pro = $('#pro').val();
            $.ajax({
                url: '{{ asset("shop/get/num") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                data: {
                    color_id: color_id,
                    size: size,
                    pro: pro
                },
                //async:false,
                success: function(data) {
                    $("#num").html('');
                    $.each(data, function(key, value){
                        $("#num").append(value.quantity);
                        $(".input-number").attr('max',value.quantity);
                    });
                    var min = $('.input-number').attr('min');
                    var max = $('.input-number').attr('max');
                    var oldValue = parseFloat($('.input-number').val());
                    var num = $("#num").text();
                    if(size==null || num ==0){
                        var max = $('.input-number').attr('max',0);
                        var min = $('.input-number').attr('min',1);
                        $(".input-number").attr('value','0');
                        $('.up').css('opacity','0');
                        $('.down').css('opacity','0');
                        $('.btn-1').attr('disabled', 'disabled');
                        $('.btn-1').text('SOLD OUT');
                        $('.btn-2').attr('disabled', 'disabled');
                        $('.btn-2').text('SOLD OUT');

                    }else{
                        $('.btn-1').prop("disabled", false);
                        $('.btn-1').text('THÊM VÀO GIỎ HÀNG');
                        $('.btn-2').prop("disabled", false);
                        $('.btn-2').text('MUA NGAY');
                        $('.up').css('opacity','1');
                        $('.down').css('opacity','1');
                        $('.up').click(function(){
                            if (oldValue >= max) {
                                var newVal = oldValue;
                            }else{
                                var newVal = oldValue+=1;
                            }
                            $('.input-number').val(newVal);
                        });
                        $('.down').click(function(){
                            if (oldValue <= min) {
                                var newVal = oldValue;
                            }else {
                                var newVal = oldValue-=1;
                            }
                            $('.input-number').val(newVal);
                        });
                    }
                    
                },error:function(){ 
                    alert("error!!!!");
                }
            });
        }

    
        $('.detail-item').owlCarousel({
            loop: true
            , items: 1
            , dots : false
            , nav :false
            , autoHeight:true
            , autoplay:true
            , autoplayTimeout:10000
            , autoplayHoverPause:false
            , responsive : {
                0 : {
                    items:1,
                    dots:true
                },
                // breakpoint from 768 up
                769 : {
                    items:1,
                    dots:false
                }
            }
        });  
        
        $('.related_products').owlCarousel({
            loop: false
            , items: 1
            , dots : false
            , margin: 30
            , autoHeight:true
            , autoplay:true
            , autoplayTimeout:10000
            , autoplayHoverPause:false
            , responsive:{
                0:{
                    items: 2,
                    nav:true
                },
                600:{
                    items: 3,
                    nav:true
                },
                1000:{
                    items: 4,
                    nav:true
                }
            }
        });
        
        
        $('.gallery .item img').click(function(){
            var src = $(this).attr('src');
            $('.detail-item .owl-item.active img').attr('src',src);
        })
    </script>
@endsection