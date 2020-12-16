@extends('layouts.themeAdmin')
@section('title', 'Tums | Đơn nhập hàng')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/bill.css') }}">
@endsection
@section('content') 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Nhập hàng</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Nhập hàng</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <form action="" method="POST" id="formSearch"> 
                        @csrf
                        <input style="padding: 8px" type="text" name="search" id="key" placeholder="Theo mã đơn, tên nhà cung cấp" autocomplete="off">
                    </form>

                    @isset($key)
                        <div class="fil-active">
                            <span style="margin-right: 10px">Kết quả cho : 
                                {{ $key }}
                                <a href="{{ asset('dashboard/imports') }}" style="float: right">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        </div>
                    @endisset

                </div>
                {{-- <div class="col-sm-2 col-md-2 col-lg-1">
                    <div class="form-group">
                        <form action="{{ asset('dashboard/orders/') }}" method="post" id="formFilter">
                            @csrf
                            <select class="form-control" name="filter" id="filter">
                                <option value="">Tất cả</option>
                                <option value="1">Chờ xác nhận</option>
                                <option value="2">Đã xác nhận</option>
                                <option value="3">Đang giao</option>
                                <option value="4">Đã thanh toán</option>
                                <option value="5">Huỷ đơn</option>
                            </select>

                            @isset($status)
                                <input type="hidden" id="status" value="{{ $status }}">
                            @endisset

                        </form>
                    </div>
                </div> --}}

                <div class="col-sm-8 act text-right">
                    <div class="d-inline-block">
                        <a href="{{ asset('dashboard/imports/create') }}">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Nhập hàng
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
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Mã hoá đơn</th>
                                    <th>Thời gian</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Người nhập</th>
                                    <th>Giảm giá</>
                                    <th>Ghi chú</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($imports as $import)
                                    <tr class="view" data-href="{{ asset('dashboard/imports/detail') }}/{{ $import->id_bill }}/{{ $import->user_id }}">
                                        <td>{{ $import->id_bill }}</td>
                                        <td>{{ $import->date }}</td>
                                        @foreach($users as  $value)
                                            @if($value->id == $import->user_id)
                                                <td>{{ $value->full_name }}</td>
                                            @endif
                                        @endforeach
                                        @foreach($users as  $value)
                                            @if($value->id == $import->seller)
                                                <td>{{ $value->full_name }}</td>
                                            @endif
                                        @endforeach
                                        <td>{{ $import->sale }}</td>
                                        <td>{{ $import->note }}</td>
                                        <td>{{ number_format($import->price_total,0,',','.') }} đ</td>
                                        <td>
                                            <span style="border-radius: 5px; background: #cccc;text-align: center;padding: 5px; display: block">
                                                @switch($import->status)
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
                                                        Huỷ đơn 
                                                        @break
                                                @endswitch
                                            </span></td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15">
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
        $('.d .nav-treeview #imports').addClass('active');

        $('.view').click(function(){
            window.location = $(this).data("href");
        });

        $('#key').keyup(function(){
            var key = $('#key').val();
            $('#formSearch').attr('action', '{{ asset("dashboard/imports/search=") }}'+key);
        });

        $('#filter').change(function(){
            var status = $('#filter').val();
            if(status==''){
                window.location ='{{ asset("dashboard/orders/") }}';
            }else{
                $('#formFilter').attr('action', '{{ asset("dashboard/imports/filter=") }}'+status);
                $('#formFilter').submit();
            }
        });

        var sta = $('#status').val();

        $('#filter').find('option').each(function(i,e){
            if($(e).val() == sta){
                $('#filter').prop('selectedIndex',i);
            }
        });

        
    </script>
@endsection
