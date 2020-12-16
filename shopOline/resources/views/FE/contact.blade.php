@extends('layouts.theme')
@section('title', 'Liên hệ - Tums')

@section('css')
    {{-- style item --}}
    {{--  <link href="{{ asset('css/front-end/abc.css') }}" rel="stylesheet">  --}}
@endsection
@section('style') 
	<style>
		#contact .active{
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
        footer{
            margin-top: 0;
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
                    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- gallery --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <form action="{{ asset('contact') }}" method="post">
                    @csrf
                    <h3>Ý KIẾN CỦA BẠN</h3>
                    @guest
                        <div class="form-group">
                            <label>Họ và tên <span style="color:red"> *</span>
                                <input type="text" class="form-control" placeholder="Họ và tên" required name="contactName">
                            </label>

                            <label>Email <span style="color:red"> *</span>
                                <input type="email" class="form-control" placeholder="Email" required name="contactEmail">
                            </label>

                            <label>Điện thoại <span style="color:red"> *</span>
                                <input type="number" class="form-control" placeholder="Điện thoại" required name="contactPhone">
                            </label>

                            <label>Nội dung liên hệ <span style="color:red"> *</span>
                                <textarea class="form-control" cols="30" rows="10" required name="contactContent"></textarea>
                            </label>
                        </div>
                        <div class="text-right" style="margin-bottom: 20px;">
                            <button class="btn btn-primary">
                                Gửi
                            </button>
                        </div>
                    @else
                        <div class="form-group">
                            <label>Họ và tên <span style="color:red"> *</span>
                                <input type="text" class="form-control" placeholder="Họ và tên" required name="contactName" value="{{ Auth::user()->full_name }}">
                            </label>

                            <label>Email <span style="color:red"> *</span>
                                <input type="email" class="form-control" placeholder="Email" required name="contactEmail" value="{{ Auth::user()->email }}">
                            </label>

                            <label>Điện thoại <span style="color:red"> *</span>
                                <input type="number" class="form-control" placeholder="Điện thoại" required  name="contactPhone" value="{{ Auth::user()->phone }}">
                            </label>

                            <label>Nội dung liên hệ <span style="color:red"> *</span>
                                <textarea class="form-control" id="" cols="30" rows="10" name="contactContent" required></textarea>
                            </label>
                        </div>
                        <div class="text-right" style="margin-bottom: 20px;">
                            <button class="btn btn-primary">
                                Gửi
                            </button>
                        </div>
                    @endguest
                </form>
            </div>

            <div class="col-lg-6">
                <h3>THÔNG TIN LIÊN HỆ</h3><br>
                 <div class="row">
                    <div class="col-2 text-right">
                        <i class=" fas fa-map-marker-alt" style="font-size: 40px"></i>
                    </div>

                    <div class="col-10">
                        <p style="font-size: 20px">ĐỊA CHỈ</p>
                        <p style="font-size: 16px">109/11 NGUYỄN BỈNH KHIÊM, P. ĐA KAO, QUÂN 1, TP.HỒ CHÍ MINH</p>
                    </div>
                 </div><br>

                 <div class="row">
                    <div class="col-2 text-right">
                        <i class=" fas fa-phone-alt" style="font-size: 40px"></i>
                    </div>

                    <div class="col-10">
                        <p style="font-size: 20px">ĐIỆN THOẠI</p>
                        <p style="font-size: 16px">0905 569 438</p>
                    </div>
                 </div><br>

                 <div class="row">
                    <div class="col-2  text-right">
                        <i class=" far fa-clock" style="font-size: 40px"></i>
                    </div>

                    <div class="col-10">
                        <p style="font-size: 20px">GIỜ LÀM VIỆC</p>
                        <p style="font-size: 16px">8 giờ sáng – 21 giờ tối</p>
                        <p style="font-size: 16px">Từ thứ 2 đến thứ 7 hàng tuần</p>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-lg-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2598764610584!2d106.69752931533417!3d10.791397261866752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528ca82567217%3A0x19e0073f6fcfa14!2zMTA5LzExIE5ndXnhu4VuIELhu4luaCBLaGnDqm0sIMSQYSBLYW8sIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1593923943019!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;width: 100%" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>

   
    <div class="modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Error</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('js')
     @if ($errors->any() || session()->has('success') )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        
        </script>
    @endif
    <script>

    </script>
@endsection