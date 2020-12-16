@extends('layouts.themeAdmin')
@section('title', 'Tums | Đơn bán lẻ')

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
                <div class="col-sm-6"></div>
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
                            @foreach($retails as  $value)
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

                                @foreach($retails as $value)
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#cancel">
                                        Hoàn kho
                                    </button>
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
                                        <span class="co">Hệ thông</span>
                                    </h6>
                                </div>
                            </header>

                            <div class="ss1-item">
                                <table class="table">
                                    <tbody>
                                        @php
                                             $sub_total=0;
                                             $sale=0;
                                             $total=0;
                                        @endphp
                                        @foreach($retail_details as $value)
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
                                        <td>- {{$sale}}</td>
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
                                @if($status == 4)
                                    <div class="mr-auto col-sm-8">
                                        <i class="fas fa-check-circle" style="color: #50b83c; margin-right: 20px"></i>
                                        <span style="font-size: 15px">ĐƠN HÀNG ĐÃ XÁC NHẬN THANH TOÁN {{ number_format($total, 0, ',', '.') }}đ</span>
                                    </div>
                                @endif
                            </div>
<hr>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="">
                            <div class="ss2 ss2-note row">
                                <div class="mr-auto col-sm-10">
                                    <h5 style="font-weight: 600; margin-bottom: 20px">Ghi chú</h5>
                                    
                                        @foreach($retails as $key => $value)
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
                                        <a href="#">
                                            {{ $users->full_name }}
                                        </a>
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
                                    <p>{{ $users->email }}</p>
                                    <p>{{ $users->phone }}</p>
                                </div>
                                {{-- <div class="ml-auto col-sm-2 text-right">
                                    <a href="">Sửa</a>
                                </div> --}}
                            </div>

                            <div class="ss2 ss2-address row">
                                <div class="mr-auto col-sm-10">
                                    <h5 style="font-weight: 600">Địa chỉ</h5>
                                    <br>
                                    <span>{{ $users->full_name }}</span>
                                    <span>{{ $users->phone }}</span>
                                    <span>{{ $users->address }}</span>
                                    <span>{{ $users->district }}</span>
                                    <span>{{ $users->provincial }}</span>
                                    <span>Vietnam</span>
                                </div>
                                {{-- <div class="ml-auto col-sm-2 text-right">
                                    <a href="">Sửa</a>
                                </div> --}}
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
                @foreach($retails as $value)
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

    {{-- modal Hoàn Kho --}}
    <div class="modal" id="cancel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hoàn kho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    <form action="{{ asset('dashboard/orders/cancel') }}/{{ $value->id_bill }}" method="post">
                        @csrf
                        <div class="modal-body">
                            {{-- <p> Bạn nên hủy đơn hàng khi thấy đơn hàng có vấn đề,
                                khi khách hàng thay đổi quyết định hoặc khi kho hàng hết sản phẩm. 
                                Thao tác này không thể khôi phục.
                            </p> --}}
                            <div class="form-group">
                                <label for="reason">Lý do trả hàng</label>
                                <select class="form-control" id="reason" name="reason">
                                    <option value="Khách thay đối quyết định">Khách thay đối quyết định</option> 
                                    <option value="Đổi trả">Đổi trả</option>
                                </select>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xác nhận</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- in hoá đơn --}}
    <div class="example-print">
        <div class=" row">
            <div class="col-12 text-center">
                <b style="font-size: 40px">
                    Hoá đơn bán lẻ
                </b><br>
                <b>Tummachines</b><br>
                <b>tummachines@gmail.com</b><br>
                <p>{{ $date }}</p>
            </div>
            <div class="col-6 text-left">
                <b>Khách hàng: </b> {{ $users->full_name }}<br>
                <b>Số điện thoại: {{ $users->phone }}<br>
                <b>Địa chỉ: </b> {{ $users->address }}<br>
            </div>
        </div><br>
        <div class="table">
            <table class="table content-print">
                <thead>
                    <tr>
                        <th class="text-center">Tên sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($retail_details as $value)
                        <tr>
                            <td style="width: 55%">
                                @foreach($products as $product)
                                    @if( $value->id_product == $product->id_product )
                                        <span>{{ $product->name_product }}</span><br>
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
                            <td style="width: 15%" class="text-center">
                                {{ $value->qty }}
                            </td>
                            <td class="text-right" style="width:15%">
                                {{ number_format($value->unit_price, 0, ',', '.') }} đ
                            </td>
                            <td class="text-right" style="width: 15%">
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
                    <td>- {{ $sale}}</td>

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

    <div class="modal" id="modal" tabindex="-1" role="dialog"aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Error</h5>
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
        $('.d .nav-treeview #retails').addClass('active');

        $('#upnote').keyup(function(){
            $('.save').prop("disabled", false);
        })
    </script>
@endsection
