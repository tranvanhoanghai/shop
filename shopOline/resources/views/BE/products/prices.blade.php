@extends('layouts.themeAdmin')
@section('title', 'Tums | Thiết lập giá')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Thiết lập giá</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Thiết lập giá</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">
                    {{-- <div class="add" data-toggle="modal" data-target="#add">
                        <i class="fas fa-plus"></i>
                        <span>Thêm mới</span>
                    </div> --}}

                    <button class="btn btn-success">
                        <i class="fas fa-eye"></i>
                        <a href="{{ asset('dashboard/products') }}" style="color: white">Xem danh sách sản phẩm</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" id="datatable">
                <div class="col-lg-2">
                    <div class="menu-left">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tìm kiếm</h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" id="formSearch"> 
                                    @csrf
                                    <input type="text"  name="search" id="key" placeholder="Theo mã, tên sản phẩm, loại">
                                </form>

                                @isset($key)
                                    <div class="fil-active">
                                        <span style="margin-right: 10px">
                                            {{ $key }}
                                            <a href="{{ asset('dashboard/prices') }}" style="float: right">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    </div>
                                @endisset
                                
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Nhóm hàng</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ asset('dashboard/prices/filter') }}" method="post" id="filterByCate">
                                    @csrf 
                                    @foreach($categorys as $value)
                                        @if(isset($cate))
                                            @if($value->name_product_type == $cate)
                                                <label style="text-transform: uppercase">
                                                    <input type="radio" name="filterByCate" checked value="{{ $value->name_product_type }}"> {{ $value->name_product_type }}
                                                    <a href="{{ asset('/dashboard/prices') }}" style="float: right">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </label>
                                            @else
                                                <label style="text-transform: uppercase">
                                                    <input type="radio" name="filterByCate" value="{{ $value->name_product_type }}"> {{ $value->name_product_type }}
                                                </label>
                                            @endif
                                        @else
                                            <label style="text-transform: uppercase">
                                                <input type="radio" name="filterByCate" value="{{ $value->name_product_type }}"> {{ $value->name_product_type }}
                                            </label>
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Hiển thị</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" id="filterByStatus">
                                    @csrf

                                    @if(isset($status))
                                        <div class="fil-active">
                                            <span style="margin-right: 10px">
                                                @if($status == 'true')Hiện @else Ẩn @endif
                                                <a href="{{ asset('dashboard/prices') }}" style="float: right">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        </div>

                                        @if($status == 'true')
                                            <label>
                                                <input type="radio" name="filterByStatus" checked value="true"> Hiện
                                            </label>
                                        @else
                                            <label>
                                                <input type="radio" name="filterByStatus" value="true"> Hiện
                                            </label>
                                        @endif

                                        @if($status == 'false')
                                            <label>
                                                <input type="radio" name="filterByStatus" checked value="false"> Ẩn
                                            </label>
                                        @else
                                            <label>
                                                <input type="radio" name="filterByStatus" value="false"> Ẩn
                                            </label>
                                        @endif
                                    @else
                                        <label>
                                            <input type="radio" name="filterByStatus" value="true"> Hiện
                                        </label>

                                        <label>
                                            <input type="radio" name="filterByStatus" value="false"> Ẩn
                                        </label>
                                    @endif
                                </form>
                                Số bản ghi
                                <select id="change-record-count" style="float: right;padding: 3px 15px 3px 2px ">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.col-md-2 -->
                <div class="col-lg-10 ">
                    <div class="right ">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá vốn</th>
                                    <th>Giá bán</th>
                                    <th>Cập nhật </th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($products as $key => $product)
                                    <form action="{{ asset('dashboard/prices/update') }}/{{ $product->id_product }}" method="post">
                                        @csrf
                                        <tr>
                                            <td style="width: 5%;text-align: center">{{ $product->id_product }}</td>
                                            
                                            <td style="width: 5%">
                                                <a href="{{ asset('dashboard/products') }}/{{ $product->id_product  }}/{{ $product->slug_product  }}">
                                                    <img src="{{ $product->img }}" alt="null" style="width: 100%">
                                                </a>
                                            </td>
                                            
                                            <td>
                                                <a href="{{ asset('dashboard/products') }}/{{ $product->id_product  }}/{{ $product->slug_product  }}">
                                                    {{ $product->name_product }}
                                                </a>
                                            </td>
                                            
                                            <td style="width: 10%"><input class="form-control" name="price0" type="number" value="{{ number_format($product->price0, 0, ',', '.') }}"></td>

                                            
                                            @if($product->price0  > $product->price1)
                                                <td style="width: 10%"><input style="color:red" class="form-control" name="price1" type="number" value="{{ number_format($product->price1, 0, ',', '.') }}"></td>
                                            @else
                                                <td style="width: 10%"><input class="form-control" name="price1" type="number" value="{{ number_format($product->price1, 0, ',', '.') }}"></td>
                                            @endif
                                            <td style="width: 10%;text-align: center">
                                                <button class="btn btn-primary" >
                                                    Lưu
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="5" style="padding: 20px;text-align: center">
                                            <h4>
                                                Không tìm thấy kết quả phù hợp
                                            </h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- {{  $supplier->links()}} --}}
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  

    
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $('.c ').addClass('menu-open');
        $('.c > .nav-link').addClass('active');
        $('.c .nav-treeview #prices').addClass('active');

        $("#filterByCate input[name='filterByCate']").click(function(){
            var cate = $('input:radio[name=filterByCate]:checked').val();
            $('#filterByCate').attr('action', '{{ asset("dashboard/prices/filter/category=") }}'+cate);
            $('#filterByCate').submit()
        });

        $("#filterByStatus input[name='filterByStatus']").click(function(){
            var status = $('input:radio[name=filterByStatus]:checked').val();
            $('#filterByStatus').attr('action', '{{ asset("dashboard/prices/filter/status=") }}'+status);
            $('#filterByStatus').submit()
        });
        
        $('#key').keyup(function(){
            var key = $('#key').val();
            $('#formSearch').attr('action', '{{ asset("dashboard/prices/search=") }}'+key);
        });

       

    </script>
@endsection
