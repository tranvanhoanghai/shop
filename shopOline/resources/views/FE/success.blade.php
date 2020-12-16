<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon" />

    <title>Tums - Cảm ơn</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front-end/success.css') }}" rel="stylesheet">

</head>
<body style="background: #e6e8ea">
    <div></div>
    <div class="container" style="margin-top: 50px">
        <div class="col-md-2 col-5">
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img style="width: 100%" src="{{asset('/img/TUMS-LOGO.png') }}" alt="">
            </a>
    </div>
        <div class="row">
               
            <div class="col-lg-7 col-sm-12">
                
                <div class="thank">
                    <div class="thank-icon">
                        <div class="svg-container">    
                            <svg class="ft-green-tick" xmlns="http://www.w3.org/2000/svg" height="70" width="70" viewBox="0 0 48 48" aria-hidden="true">
                                <circle class="circle" fill="#5bb543" cx="24" cy="24" r="22"/>
                                <path class="tick" fill="none" stroke="#FFF" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M14 27l5.917 4.917L34 17"/>
                            </svg>
                        </div>
                    </div>
                        
                    
                    <div class="thank-mess">
                        <h5><b>Cảm ơn bạn đã đặt hàng</b></h5>
                    {{ $user->email }}
                    <p>Một email xác nhận đã được gửi tới {{ $user->email }}. Xin vui lòng kiểm tra email của bạn</p> 
                    </div>
                </div>
                <div class="ship-info">
                    <div class="row">
                        <div class="ship-info1 col-sm-6 col-md-6">
                            <h5>
                                Thông tin nhận hàng
                            </h5>{{ $user->addess }}</p>
                            <p>{{ $user->district }}</p>
                            <p>{{ $user->provincial }}</p>
                            <p>Vietnam</p>
                            <p>{{ $user->phone }}</p>
                           
                        </div>
                        <div class="ship-info2 col-sm-6 col-md-6">
                            <h5>
                                Thông tin thanh toán
                            </h5>
                            <p>{{ $user->addess }}</p>
                            <p>Quận huyện</p>
                            <p>Tỉnh</p>
                            <p>Vietnam</p>
                            <p>{{ $user->phone }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <h5>
                                Hình thức thanh toán
                            </h5>
                            <p>&emsp;Thanh toán khi giao hàng (COD)</p>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <h5>
                                Hình thức vận chuyển
                            </h5>
                            <p>&emsp;Giao hàng tận nơi - 30.000₫</p>
                        </div>
                    </div>
                </div>
                <div  class="b">
                    <a href="{{ asset('shop') }}">
                        <button >
                            Tiếp tục mua hàng
                        </button>

                    </a>
                    <a href="{{ asset('account') }}">
                        <button style="margin-right: 50px;">
                            Theo dõi đơn hàng
                        </button>

                    </a>
                </div>
            </div>

            <div class="col-md-5 col-sm-12">
                
            </div>
        </div>
    </div>

    </div>

    <script>
        let path = document.querySelector(".tick");
let length = path.getTotalLength();

console.log(length); 
    </script>
</body>
</html>