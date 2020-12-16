<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- SEO --}}
    <meta name="description" content="Tums thương hiệu thời trang đến từ Việt Nam với chất liệu được chọn lọc và nhập khẩu từ Hàn Quốc | Hotline: 0905 569 438 "/>
    <meta name="keywords" content="Tums" />
    <meta name="robots" content="index,follow"/>
    <link rel="canonical" href="{{ asset('/') }}" />
    <link rel='shortlink' href="{{ asset('/') }}" />
    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    {{-- owl carousel --}}
    <link href="{{ asset('css/lib/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/owl.theme.default.css') }}" rel="stylesheet">
    {{-- lib hover --}}
    <link href="{{ asset('css/lib/hover.css') }}" rel="stylesheet"> 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front-end/style.css') }}" rel="stylesheet"> 
    @yield('css')
</head>
@yield('style')
<body>
    <div class="load">
        <img style="margin: auto" src="https://media0.giphy.com/media/3oEjI6SIIHBdRxXI40/200.gif">
    </div>

    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <nav class="navbar navbar-expand-lg shadow-sm">
                    <div class="container">
                        <div class="d-lg-none col-sm-2 col-3 a">
                            <button style="outline:none;" class="navbar-toggler" data-hide="hideDown" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                                <span>
                                    <div id="nav-icon1">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </span>
                            </button>  
                        </div>
                        <div class=" col-xl-4 col-lg-3 col-sm-8 col-7 logo" >
                            <a class="navbar-brand" href="{{ url('/home') }}" >
                                <img src="{{asset('/img/LOGO.png') }}" alt="">
                            </a>
                        </div>
                        
                        <div class="col-xl-7 col-lg-8 col-sm-5 col-5 d-md-none d-sm-none d-none d-lg-block ">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item" id="home">
                                        <a class="nav-link" href="{{ asset('/home') }}">HOME</a>
                                        <div class="active"></div>
                                    </li>
                                    <li class="nav-item i" style="position: relative" id="shop">
                                        <a class="nav-link" href="{{ asset('shop') }}">
                                            SHOP
                                            <i style="margin-left: 5px;" class="fas fa-chevron-left"></i>
                                        </a>
                                        <div class="sub-menu">
                                            @forelse($categorys as $value)
                                                <ul style="padding: 0" >
                                                    <li class="nav-item">
                                                        <a href="{{ asset('/category/'.$value->name_product_type) }}">
                                                            {{ $value->name_product_type }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="active"></div>
                                    </li>
                                    <li class="nav-item" id="about">
                                        <a class="nav-link" href="{{ asset('about') }}">ABOUT US</a>
                                        <div class="active"></div>
                                    </li>
                                    {{-- <li class="nav-item" id="blog">
                                        <a class="nav-link" href="{{ asset('blog') }}">BLOG</a>
                                        <div class="active"></div>
                                    </li> --}}
                                    <li class="nav-item" id="contact">
                                        <a class="nav-link" href="{{ asset('contact') }}">CONTACT</a>
                                        <div class="active"></div>
                                    </li>
                                </ul>
                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                        <div class="dropdown" style="display: flex;justify-content: center;align-items: center">
                                            <a href="#" class="dropdown-toggle"data-toggle="dropdown">
                                                <i class="fas fa-user"  style=" font-size: 20px"></i>
                                                <span class="caret"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                                @if (Route::has('register'))
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            </div>
                                        </div>
                                    @endif
                                    @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->full_name }} <span class="caret"></span>
                                        </a>
                    
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ asset('account') }}">
                                                Account
                                            </a>

                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            @if($roles->id_user_type == 1 || $roles->id_user_type == 2 )
                                                <a class="dropdown-item" href="{{ asset('dashboard') }}">
                                                    Dashboard
                                                </a>
                                            @endif
                    
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                        <div class="nav-item cart col-lg-1 col-sm-2 col-2" style="position: relative">
                            <a href="{{ asset('cart') }}">
                                <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                                <span class="num">
                                    {{-- @guest --}}
                                        {{ Cart::count() }}
                                    {{-- @else 
                                        @if($count_cart->count == '')
                                            0
                                        @else
                                            {{ $count_cart->count }}
                                        @endif
                                    @endguest --}}

                                </span>
                            </a>
                        </div>
                    </div>

                    {{-- MENU MOBILE --}}
                    <div class="sidebar">
                        <ul>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('/home') }}">HOME</a>
                            </li>

                            <li class="nav-item i" style="position: relative">
                                <a class="nav-link" href="#" data-toggle="collapse" data-target="#submenu">
                                    SHOP
                                    <i style="margin-left: 5px;" class="fas fa-plus"></i>
                                </a>

                                <div class="row">
                                    <div class="col">
                                      <div class="collapse multi-collapse" id="submenu">
                                            <div class="sub-menu2">
                                                <ul style="padding: 0">
                                                    <li>
                                                        <a href="{{ asset('shop') }}">
                                                        all item
                                                    </a>
                                                    </li>
                                                    @foreach($categorys as $value)
                                                        <li class="nav-item">
                                                            <a href="{{ asset('/category/'.$value->name_product_type) }}">
                                                                {{ $value->name_product_type }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                      </div>
                                    </div>
                                  </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('about') }}">ABOUT US</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ asset('blog') }}">BLOG</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('contact') }}">CONTACT</a>
                            </li>
                            
                            @guest
                                <div class="dropdown" style="padding: 15px 30px">
                                    <a href="#" class="dropdown-toggle"data-toggle="dropdown">
                                        <i class="fas fa-user"  style=" font-size: 20px"></i>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                    </div>
                                </div>
                                        @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->full_name }} <span class="caret"></span>
                                    </a>
                
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ asset('account') }}">
                                            Account
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        @if($roles->id_user_type == 1 || $roles->id_user_type == 2 )
                                            <a class="dropdown-item" href="{{ asset('dashboard') }}">
                                                Dashboard
                                            </a>
                                        @endif
                
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                      </div>
                </nav>
            </div>
            
        </div>
    </div>
    <main>
        @yield('content')
    </main>
 
    {{-- BACK TO TOP --}}
    <div class="back-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    {{-- FOOTER --}}
    <footer>
        <div class="container" style="max-width:1200px;">
            <div class="row" style="padding-top: 50px;">
                <div class="col-md-4 left-footer">
                    <h2>Thông tin</h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('/') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('/about') }}">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('/contact') }}">Liên hệ</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 text-center" >
                    <a href="{{ asset('/') }}"><img src="{{ asset('/img/LOGO.png') }}" alt="" style="width: 50%"></a>
                    <div class="py-5">
                        <a href="javascript:void(0)" ><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" ><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" ><i class="fab fa-google" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="col-md-4 right-footer text-right">
                    <h2>Liên hệ</h2>
                    <ul>
                        <li>
                            <p><i class="fas fa-home"></i> 109/11 Nguyễn Bỉnh khiêm, Quận 1, TP.HCM</p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope"></i> tummachine0614@gmail.com </p>
                        </li>
                        <li>
                            <p><i class="fas fa-phone"></i>0905 569 438</p>
                        </li>
                    <ul>
                </div>
            </div>
        </div>

        <div class="container" style="border-top: 1px solid white; ">
            <div class="row">
              <div class="col-md-12 text-left py-4">
                <span style="color: white">© 2020 Designed By Hoang Hai</span>
              </div>
            </div>
          </div>

    </footer>

    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('js/js.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
    @yield('js')
    <script>
        $(window).on('load', function() {
            $('.load').delay(1000).fadeOut('fast');
        });
        
        $(document).ready(function(){
            $(".a button").click(function() {
                $(".sidebar").toggleClass($(this).attr("data-hide"));
            });
        });
    </script>
</body>
</html>