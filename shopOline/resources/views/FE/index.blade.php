@extends('layouts.theme')
@section('title','Tums Clo -- Be A Pioneer') 

@section('style') 
<style>
    #home .active{
        background: white;
        height: 2px;
        width: 100%;
        transition: 1s;
    }
</style>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding: 0">
                <div class="owl-carousel owl-theme slide">
                    @foreach($sliders as $key => $slider)
                        <div class="item">
                            <a href="{{ asset($slider->link) }}">
                                <img src="{{ $slider->img }}"> 
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- PRODUCT NEW --}}
        <div class="container">
            <div class="row">
                <h2 style="text-align: center;width: 100%;font-weight: bold;margin:50px 0;">SẢN PHẨM MỚI</h2>
                <div class="col-lg-12" style="padding: 0">
                    <div class="owl-carousel owl-theme new-product">
                        @foreach($new_product as $value)
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

        {{-- PRODUCT BEST SELLER --}}
        <div class="container">
            <div class="row">
                <h2 style="text-align: center;width: 100%;font-weight: bold;margin:50px 0;">SẢN PHẨM BÁN CHẠY</h2>
                <div class="col-lg-12" style="padding: 0">
                    <div class="owl-carousel owl-theme new-product">
                        @foreach($best_sellers as $value)
                            <?php
                                $ds = [];		
                            ?>
                            @foreach($image as $img)
                                @if($value->id_product == $img->id_product)
                                    <?php
                                        array_push($ds, $img->image);
                                    ?>
                                @endif
                            @endforeach
                            <div class="item">
                                <div class="img-product">
                                    <a href="{{ asset('shop') }}/{{ $value->slug_product }}" title="">
                                        <div class="front">
                                            <img src="{{ $ds[0] }}">
                                        </div>

                                        <div class="back">
                                            <img src="{{ $ds[1] }}">
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
@endsection

@section('js')
    <script>
        $('.slide').owlCarousel({
            loop: true
            , items: 1
            , nav: true
            , autoplay: true
            , autoplayTimeout: 5000
            , autoplayHoverPause: false
            
        });

        $('.new-product').owlCarousel({
            loop: true
            , items: 1
            , nav: true
            , margin: 30
            , dots : false
            , autoplay: true
            , autoplayTimeout: 5000
            , autoplayHoverPause: false
            , responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:true
                },
                1000:{
                    items:4,
                    nav:true
                }
            }
        });

        $(window).bind('scroll', function() {
            var navHeight = $(window).height() - 500;
            if ($(window).scrollTop() > navHeight) {
                $('.navbar').addClass('fixed');
                $('.navbar-brand img').attr('src', 'img/TUMS-LOGO.png');
                $('.back-top').css('opacity',1);
                $('#nav-icon1 span').css('background','black');
                $('.sidebar').css('background','white');
            } else {
                $('.navbar').removeClass('fixed');
                $('.navbar-brand img').attr('src', 'img/LOGO.png');
                $('.back-top').css('opacity',0);
                $('#nav-icon1 span').css('background','white');
                $('.sidebar').css('background','black');
            }
        });
    </script>
    <!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v8.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="101812038226776"
  theme_color="#000000"
  logged_in_greeting="Xin chào, chúng tôi có thể giúp gì cho bạn không ?"
  logged_out_greeting="Xin chào, chúng tôi có thể giúp gì cho bạn không ?">
      </div>
    </script>
@endsection
