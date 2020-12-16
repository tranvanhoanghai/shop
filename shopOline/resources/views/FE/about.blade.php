@extends('layouts.theme')
@section('title', 'About us - Tums')
@section('style') 
	<style>
        
		#about .active{
			background: white;
			height: 2px;
			width: 100%;
			transition: 1s;
        }
        #app .navbar {
            position: relative;
            transition: 2s;
            background-color: rgba(0, 0, 0, 1);
        }
        #nav-icon1 span{
            background: white;
        }
        label{
            display: block;
            margin-bottom: 20px;
        }
        .btn-contact{
            border: 1px solid;
            display: inline-block;
        }
        .btn-contact a{
            color:black;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: .5s;
        }
        .btn-contact:hover a{
            color:white;
            background: black
        }

	</style>
@endsection
@section('content')
    {{-- breadcrumb --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: none;">
                    <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Home</a></li>
                    <li class="breadcrumb-item active">About us</li>
                </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container"">
        <div class="row pb-5" >
            <div class="col-lg-12" style="text-align: center">
                <h1 style="font-weight: bold">CHÀO MỪNG BẠN ĐẾN VỚI TUMMACHINES</h1>
                <h5 style="color:#808080;">Trong một ngành công nghiệp cạnh tranh như ngành thời trang, chúng tôi phải luôn nỗ lực để phân biệt thương hiệu của bạn với các thương hiệu cạnh tranh khác.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-4">
                <img src="https://c1.peakpx.com/wallpaper/553/347/654/botique-clothing-fashion-store-wallpaper.jpg" alt="" style="width: 100%">
            </div>
            <div class="col-md-6">
                <h2>CỬA HÀNG TUMMACHINES</h2>
                <p class="py-2">Năm 2020, chúng tôi cho ra đời thương hiệu thời trang TUMMACHINES nhằm khai thác nhu cầu đang tăng lên của thị trường nội địa.
                    Thương hiệu TUMMACHINES vừa ra mắt đã được khách hàng đánh giá rất cao về các dòng sản phẩm,
                    mẫu mã phong phú và chất lượng tốt.
                </p>
                <p>
                    Cho đến nay, TUMMACHINES luôn nỗ lực không ngừng trong việc đa dạng hoá dòng sản phẩm để phục vụ nhu cầu ngày càng cao của khách hàng.
                     Tại TUMMACHINES, các mẫu thiết kế liên tục được kiểm duyệt kĩ càng ở từng khâu chọn chất liệu, dựng mẫu và hoàn thiện.
                      Với đội ngũ thiết kế chuyên nghiệp, được đào tạo bài bản về chuyên môn và kinh nghiệm nhiều năm,
                      TUMMACHINES hy vọng sẽ làm hài lòng cả những khách hàng khó tính nhất.
                </p>
                <div class="btn-contact">
                    <a href="{{ asset('/contact') }}">
                        Liên hệ với chúng tôi
                    </a>
                </button>
            </div>
        </div>
    </div>
   
@endsection
