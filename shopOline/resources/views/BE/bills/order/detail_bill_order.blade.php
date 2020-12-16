@extends('layouts.themeAdmin')
@section('title', 'Tums | Đơn đặt hàng')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/bill.css') }}">
@endsection

@section('content') 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Đặt hàng</li>
                    </ol> --}}
                </div>
            </div>
        </div>
       
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content example-screen">
        
            <div class="container">
                <div class="row" id="datatable">
                    <div class="col-lg-12">
                        <div class="ui-title-bar">
                            <h5>
                                <a href="{{ asset('dashboard/orders/') }}" class="">
                                    <i class="fas fa-chevron-left"></i>    
                                    Đơn hàng
                                </a>
                            </h5>
                            <span style="font-weight: 500;font-size: 50px">
                                #{{ $id }}
                            </span>
                            @foreach($orders as  $value)
                                <span class="co" style="font-size: 20px">
                                    {{ $value->date }}
                                </span>
                                @php
                                    $date = $value->date
                                @endphp
                            @endforeach
                            <div style="margin-bottom: 20px">
                                <button class="btn btn-primary"onclick="window.print()" type="button">
                                    In đơn hàng
                                </button>

                                @foreach($orders as $key => $value)
                                    @if($value->status == 1)
                                        <form action="{{ asset('dashboard/orders/confirm') }}/{{ $value->id_bill }}" method="post">
                                            @csrf
                                            <button class="btn btn-success" type="submit">
                                                Xác nhận
                                            </button>
                                        </form>
                                    @endif
                                
                                    @if($value->status == 1 || $value->status == 2)
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#cancel">
                                            Huỷ đơn
                                        </button>
                                    @endif
                                    
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-10 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="ss1">
                            <header class="ss1-heard row border-bottom">
                                <div class="col-md-6">
                                    <h5 style="font-weight: 600">Chi tiết đơn hàng</h5>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <h6 style="font-weight: 500">
                                        Nguồn
                                        <span class="co">Website</span>
                                    </h6>
                                </div>
                            </header>

                            <div class="ss1-item">
                                <table class="table">
                                    <tbody>
                                        @php
                                             $sub_total=0;
                                             $sale=0;
                                             $ship=0;
                                             $total=0;
                                        @endphp
                                        @foreach($order_details as $value)
                                            <tr>
                                                <td style="width: 10%">
                                                    @foreach($products as $product)
                                                        @if( $value->id_product == $product->id_product )
                                                            <img src="{{ $product->img }}"alt="image_product {{ $value->id_product }}">
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <span class="d-block">
                                                        @foreach($products as $product)
                                                            @if( $value->id_product == $product->id_product )
                                                                {{ $product->name_product }}
                                                            @endif
                                                        @endforeach
                                                    </span>

                                                    @foreach($sizes as $key => $size)
                                                        @if($value->id_size == $size->id_size)
                                                            <span>{{ $size->size }} </span>,
                                                        @endif
                                                    @endforeach
                                                    
                                                    @foreach($colors as $key => $color)
                                                        @if($value->id_color == $color->id_color)
                                                            <span>{{ $color->color }} </span>
                                                        @endif
                                                    @endforeach
                                                    
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($value->unit_price, 0, ',', ' ') }}đ
                                                </td>
                                                <td>x</td>
                                                <td>
                                                    {{ $value->qty }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($value->unit_price*$value->qty, 0, ',', ' ') }}đ
                                                </td>
                                            </tr>
                                            @php
                                                $sub_total += $value->unit_price*$value->qty;
                                                $total=$value->price_total;
                                                $ship=$value->price_ship;
                                                $sale=$value->sale;
                                                $status=$value->status;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
<hr>
                            <div class="ss1-price">
                                <table class="table text-right ">
                                    <tr class=" border-0">
                                        <td></td>
                                        <td></td>
                                        <td colspan="4"class="co">Giá</td>
                                        <td>{{ number_format($sub_total, 0, ',', ' ') }}đ</td>
                                    </tr>
                                    <tr class=" border-0">
                                        <td></td>
                                        <td></td>
                                        <td colspan="4" class="co">Sale</td>
                                        <td>- {{$sale }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="4"class="co">Ship</td>
                                        <td>{{ number_format($ship, 0, ',', ' ') }}đ</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="4">
                                            <b>Tổng cộng </b>
                                        </td>
                                        <td>
                                            <b>{{ number_format($total, 0, ',', ' ') }}đ</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
<hr>
                            <div class="ss1-payment row">
                                {{-- @if($status == 4)
                                    <div class="mr-auto col-sm-8">
                                        <i class="fas fa-check-circle" style="color: #50b83c; margin-right: 20px"></i>
                                        <span style="font-size: 15px">ĐƠN HÀNG ĐÃ XÁC NHẬN THANH TOÁN {{ number_format($total, 0, ',', '.') }}đ</span>
                                    </div>
                                @else
                                    <div class="mr-auto col-sm-8">
                                        <i class="fas fa-credit-card"></i>
                                        <span>THANH TOÁN KHI GIAO HÀNG(COD)</span>
                                    </div>
                                @endif --}}

                                <div class="ml-auto col-sm-4 text-right">
                                    @if($status != 4 && $status != 5)
                                        <button class="btn" data-toggle="modal" data-target="#pay">
                                            Xác nhận
                                        </button>
                                    @endif

                                    {{-- <form action="{{ asset('dashboard/orders/cancel') }}/{{ $id }}" method="post">
                                        @csrf
                                        <button class="btn" type="submit">
                                            Hoàn kho
                                        </button>
                                    </form> --}}
                                </div>
                            </div>
<hr>
                            <div class="ss1-cod row">
                                @if($status == 4 || $status == 3)
                                    <div class="mr-auto col-sm-8">
                                        <i class="fas fa-check-circle" style="color: #50b83c; margin-right: 20px;font-size: 18px"></i>
                                        <span style="font-size: 15px">TẤT CẢ SẢN PHẨM ĐÃ ĐƯỢC GIAO</span>
                                    </div>
                                @else
                                    <div class="mr-auto col-sm-8">
                                        <i class="fas fa-truck co"></i>
                                        <span>GIAO HÀNG</span>
                                    </div>
                                @endif

                                <div class="ml-auto col-sm-4 text-right">
                                    @if($status != 4 && $status != 3 && $status != 5)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#cod">
                                            Giao hàng
                                        </button>
                                    @endif
                                </div>
                            </div>
<hr>
                        </div>

                        <div class="ss1-active ">
                            <div class=" col-sm-12">
                                <h5 style="font-weight: 600">Hoạt động</h5>
                            </div>
                            <hr>
                            <div class="col-sm-12  ">
                                <div class="timeline">
                                    <ul class="timeline-list">
                                        <li class="timeline-item co" style="font-size: 25px">
                                            {{ $date }}
                                        </li>
                                        
                                        @foreach($orders as $value)
                                            @if($value->status == 5)
                                                <li class="timeline-item border-bottom">
                                                    <span class="active"></span>
                                                    Đã huỷ
                                                </li> 
                                            @else
                                                <li class="timeline-item">
                                                    Đã huỷ
                                                </li>
                                            @endif
                                            
                                            @if($value->status == 4)
                                                <li class="timeline-item border-bottom">
                                                    <span class="active"></span>
                                                    Đã giao hàng
                                                </li> 
                                            @else
                                                <li class="timeline-item">
                                                    Đã giao hàng
                                                </li>
                                            @endif
                                           
                                            @if($value->status == 3)
                                                <li class="timeline-item border-bottom">
                                                    <span class="active"></span>
                                                    Đang giao hàng
                                                </li> 
                                            @else
                                                <li class="timeline-item">
                                                    Đang giao hàng
                                                </li>
                                            @endif

                                            @if($value->status == 2)
                                                <li class="timeline-item border-bottom">
                                                    <span class="active"></span>
                                                    Xác nhận đơn hàng
                                                </li>
                                            @else
                                                <li class="timeline-item">
                                                    Xác nhận đơn hàng
                                                </li>
                                            @endif

                                            @if($value->status == 1)
                                                <li class="timeline-item border-bottom">
                                                    <span class="active"></span>
                                                    Chờ xác nhận 
                                                </li>
                                            @else
                                                <li class="timeline-item">
                                                    Chờ xác nhận 
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="">
                            <div class="ss2 ss2-note row">
                                <div class="mr-auto col-sm-10">
                                    <h5 style="font-weight: 600; margin-bottom: 20px">Ghi chú</h5>
                                    
                                        @foreach($orders as $key => $value)
                                            @if($value->note == null)
                                                <span class="co">Không có ghi chú</span>
                                            @endif
                                            {{ $value->note }}
                                        @endforeach
                                </div>
                                <div class="ml-auto col-sm-2 text-right">
                                    <a href="#" data-toggle="modal" data-target="#upnote">Sửa</a>
                                </div>
                            </div>

                            <div class="ss2 ss2-cus row">
                                <div class="mr-auto col-sm-10">
                                    <h5 style="font-weight: 600">Khách hàng</h5>
                                    <br>
                                        @foreach($users as $key => $value)
                                            <a href="#">
                                                {{ $value->full_name }}
                                            </a>
                                        @endforeach
                                        <br>
                                        @foreach($bill_count as $key => $value)
                                            <a href="#">
                                                {{ $value->count_bill }} đơn hàng
                                            </a>
                                        @endforeach
                                </div>
                                {{-- <div class="ml-auto col-sm-2 text-right">
                                    <a href="">Sửa</a>
                                </div> --}}
                            </div>

                            <div class="ss2 ss2-cus row">
                                <div class="mr-auto col-sm-10">     
                                    <h5 style="font-weight: 600">Liên hệ</h5>
                                    <br>
                                        @foreach($users as $key => $value)
                                            {{ $value->email }}
                                        @endforeach
                                </div>
                                {{-- <div class="ml-auto col-sm-2 text-right">
                                    <a href="">Sửa</a>
                                </div> --}}
                            </div>

                            <div class="ss2 ss2-address row">
                                <div class="mr-auto col-sm-10">
                                    <h5 style="font-weight: 600">Địa chỉ giao hàng</h5>
                                    <br>
                                        @foreach($users as $key => $value)
                                            <span>{{ $value->full_name }}</span>
                                            <span>{{ $value->phone }}</span>
                                            <span>{{ $value->address }}</span>
                                            <span>{{ $value->district }}</span>
                                            <span>{{ $value->provincial }}</span>
                                            <span>Vietnam</span>
                                        @endforeach
                                </div>
                                {{-- <div class="ml-auto col-sm-2 text-right">
                                    <a href="">Sửa</a>
                                </div> --}}
                            </div>

                            <div class="ss2 ss2-shipping row">
                                <span class="co">Phương thức vận chuyển: </span>
                                <b>&ensp; Giao hàng tận nơi</b>
                                <span class="co">Khối lượng:  </span>
                                <b>&ensp; 0.0kg</b>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
      
      <!-- Modal UPDATE NOTE-->
    <div class="modal" id="upnote" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa ghi chú</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                @foreach($orders as $key => $value)
                    <form action="{{ asset('dashboard/orders/detail/upnote') }}/{{ $value->id_bill }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <textarea class="form-control" id="upnote" rows="3" name="upnote">{{ $value->note }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Huỷ</button>
                            <button type="submit" class="btn btn-primary save" disabled>Lưu</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    {{-- modal huỷ đơn --}}
    <div class="modal" id="cancel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Huỷ đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    <form action="{{ asset('dashboard/orders/cancel') }}/{{ $value->id_bill }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>Bạn nên hủy đơn hàng khi thấy đơn hàng có vấn đề,
                                khi khách hàng thay đổi quyết định hoặc khi kho hàng hết sản phẩm. 
                                Thao tác này không thể khôi phục.
                            </p>
                            <div class="form-group">
                                <label for="reason">Lý do huỷ đơn</label>
                                <select class="form-control" id="reason" name="reason">
                                  <option value="Thông tin khách hàng không hợp lệ">Khách thay đối quyết định</option> 
                                  <option value="Spam">Spam</option>
                                  <option value="Hết hàng">Hết hàng</option>
                                </select>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Không Huỷ</button>
                            <button type="submit" class="btn btn-danger">Huỷ</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- modal xác nhận thanh toán--}}
    <div class="modal" id="pay" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Huỷ đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/orders/pay') }}/{{ $id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>
                            Xác nhận khách hàng đã thanh toán số tiền {{  number_format($total, 0, ',', '.') }} đ cho phương thức thanh toán Thanh toán khi giao hàng (COD) cho đơn hàng này
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"> Huỷ</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     {{-- modal xác nhận giao hàng--}}
     <div class="modal" id="cod" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Giao đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/orders/cod') }}/{{ $id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>
                            Xác nhận giao hàng
                        </p>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"> Huỷ</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- in hoá đơn --}}
    <div class="example-print">
        <div class=" row">
            <div class="col-sm-6">
                <b style="font-size: 40px">
                    Tummachines
                </b>
                <br><br>
                <b>Tummachines.com</b> <br> <br>
                <b>tummachines@gmail.com</b> <br> <br>
                <b>Địa chỉ nhận hàng</b> <br> <br>
                @foreach($users as $value)
                    <p>{{ $value->full_name }}</p>
                    <p>{{ $value->phone }}</p>
                    <p>{{ $value->email }}</p>
                    <p>{{ $value->address }}, {{ $value->district }}, {{ $value->provincial }}</p>
                @endforeach
            </div>

            <div class="col-sm-6">
                <br>
                <br>
                <br>
                <p>Ngày đặt hàng : {{ $date }}</p>
                <p>Mã đơn hàng : #{{ $id }}</p>
                <br>
                <p><b>Hình thức thanh toán</b></p>
                <p>Thanh toán khi giao hàng (COD)</p>
                <br>
                <p><b>Hình thức giao hàng</b></p>
                <p>Giao hàng tận nơi</p>
            </div>
        </div>

        <div class="">
            <table class="table content-print">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_details as $value)
                        <tr>
                            <td style="width: 70%">
                                @foreach($products as $product)
                                    @if( $value->id_product == $product->id_product )
                                        <p>{{ $product->name_product }}</p>
                                    @endif
                                @endforeach

                                @foreach($sizes as $key => $size)
                                    @if($value->id_size == $size->id_size)
                                        <span>{{ $size->size }} </span>,
                                    @endif
                                @endforeach
                                
                                @foreach($colors as $key => $color)
                                    @if($value->id_color == $color->id_color)
                                        <span>{{ $color->color }} </span>
                                    @endif
                                @endforeach
                            </td>
                            <td style="width: 10%" class="text-center">
                                {{ $value->qty }}
                            </td>
                            <td class="text-right" style="width:10%">
                                {{ number_format($value->unit_price, 0, ',', '.') }} đ
                            </td>
                            <td class="text-right" style="width: 10%">
                                {{ number_format($value->unit_price*$value->qty , 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table text-right print">
                <tr class=" border-0">
                    <td></td>
                    <td></td>
                    <td colspan="4">Chiết khấu</td>
                    <td>- {{  $sale }}</td>

                </tr>
                <tr class=" border-0">
                    <td></td>
                    <td></td>
                    <td colspan="4">Giá sau chiết khấu</td>
                    <td>{{ number_format($sub_total, 0, ',', ' ') }}đ</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4">Phí vận chuyển</td>
                    <td>{{ number_format($ship, 0, ',', ' ') }}đ</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4">
                        <b>Tổng tiền </b>
                    </td>
                    <td>
                        <b>{{ number_format($total, 0, ',', ' ') }}đ</b>
                    </td>
                </tr>
            </table>
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
        $('.d ').addClass('menu-open');
        $('.d > .nav-link').addClass('active');
        $('.d .nav-treeview #orders').addClass('active');

        $('#upnote').keyup(function(){
            $('.save').prop("disabled", false);
        })
    </script>
@endsection
