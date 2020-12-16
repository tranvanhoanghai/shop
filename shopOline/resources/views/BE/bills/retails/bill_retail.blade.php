@extends('layouts.themeAdmin')
@section('title', 'Tums | Hoá đơn bán lẻ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/bill.css') }}">
@endsection
@section('content') 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Đặt hàng</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Hoá đơn đặt hàng</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <form action="" method="POST" id="formSearch"> 
                        @csrf
                        <input style="padding: 8px" type="text" name="search" id="key" placeholder="Theo mã đơn, tên khách hàng" autocomplete="off">
                    </form>

                    @isset($key)
                        <div class="fil-active">
                            <span style="margin-right: 10px">Kết quả cho : 
                                {{ $key }}
                                <a href="{{ asset('dashboard/retails') }}" style="float: right">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        </div>
                    @endisset

                </div>

                <div class="col-sm-8 act text-right">
                    <div class="d-inline-block">
                        <a href="{{ asset('dashboard/sales') }}">
                            <button class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i>
                                Bán hàng
                            </button>
                        </a>
                    </div>
                    {{--  <div class="d-inline-block">
                        <button class="btn btn-success">
                            <i class="fas fa-sign-out-alt"></i>
                            Xuất file
                        </button>
                    </div>  --}}
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-lg-12 ">
                    <div class="right" style="width: 100%;; overflow-x: auto">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã hoá đơn</th>
                                    <th>Thời gian</th>
                                    <th>Khách hàng</th>
                                    <th>Người Bán</th>
                                    <th>Giảm giá</th>
                                    <th>Ghi chú</th>
                                    <th>Tình trạng</th>
                                    <th>Tổng tiền</th> 
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($retails as $key => $retail)
                                    <tr class="view" data-href="{{ asset('dashboard/retails/detail') }}/{{ $retail->id_bill }}/{{ $retail->user_id }}"@if($retail->status == 5)
                                        style="color:red"
                                    @endif>
                                        <td>{{ $retail->id_bill }}</td>
                                        <td>{{ $retail->date }}</td>

                                        @foreach($users as  $value)
                                            @if($value->id == $retail->user_id)
                                                <td>{{ $value->full_name }}</td>
                                            @endif
                                        @endforeach
                                        @foreach($users as  $value)
                                            @if($value->id == $retail->seller)
                                                <td>{{ $value->full_name }}</td>
                                            @endif
                                        @endforeach
                                        <td>{{ $retail->sale }}</td>
                                        <td>{{ $retail->note }}</td>
                                        
                                        <td><span style="border-radius: 5px; background: #cccc;text-align: center;padding: 5px; display: block">
                                            @switch($retail->status)
                                                @case(1)
                                                    Chờ xác nhận
                                                    @break
                                                @case(2)
                                                    Đã xác nhận đơn hàng
                                                    @break
                                                @case(3)
                                                    Giao cho vận chuyển
                                                    @break
                                                @case(4)
                                                    Đã thanh toán
                                                    @break
                                                @case(5)
                                                    Hoàn kho
                                                    @break
                                            @endswitch
                                        </span></td>

                                        <td>{{ number_format($retail->price_total,0,',','.') }} đ</td>
                                       
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center">
                                            Không có hoá đơn phù hợp..
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection 





@section('js')
    <script>
        $('.d ').addClass('menu-open');
        $('.d > .nav-link').addClass('active');
        $('.d .nav-treeview #retails').addClass('active');

        $('.view').click(function(){
            window.location = $(this).data("href");
        });

        $('#key').keyup(function(){
            var key = $('#key').val();
            $('#formSearch').attr('action', '{{ asset("dashboard/retails/search=") }}'+key);
        });

        

        
    </script>
@endsection
