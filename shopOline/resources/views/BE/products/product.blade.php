@extends('layouts.themeAdmin')
@section('title', 'Sản phẩm')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header"> 
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Sản phẩm</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">
                    <div class="d-inline-block">
                        <a href="{{ asset('dashboard/products/create') }}" style="color: white">
                            <button class="btn btn-success"><i class="fas fa-plus"></i>Thêm sản phẩm</button>
                        </a>
                    </div>
                    
                    {{-- <div class="d-inline-block">
                        <button class="btn btn-success" data-toggle="modal" data-target="#import">
                            <i class="fas fa-file-import"></i>
                            Nhập file
                        </button>
                    </div>

                    <div class="d-inline-block">
                        <button class="btn btn-success" data-toggle="modal" data-target="#export">
                            <i class="fas fa-file-export"></i>
                            Xuất file
                        </button>
                    </div> --}}

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
                                    <input type="text" name="search" id="key" placeholder="Theo mã, tên hàng" autocomplete="off">
                                </form>

                                @isset($key)
                                    <div class="fil-active">
                                        <span style="margin-right: 10px">
                                            {{ $key }}
                                            <a href="{{ asset('dashboard/products') }}" style="float: right">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    </div>
                                @endisset
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Loại sản phẩm</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ asset('dashboard/products/filter') }}" method="post" id="filterByCate">
                                    @csrf
                                    @foreach($categorys as $value) 
                                        @if(isset($cate))
                                            @if($value->name_product_type == $cate)
                                                <label style="text-transform: uppercase">
                                                    <input type="radio" name="filterByCate" checked value="{{ $value->name_product_type }}"> {{ $value->name_product_type }}
                                                    <a href="{{ asset('/dashboard/products') }}" style="float: right">
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
                                                <a href="{{ asset('dashboard/products') }}" style="float: right">
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
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-2 -->
                <div class="col-lg-10">
                    <div class="right">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Loại sản phẩm</th>
                                    <th>Kho</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($products as $product )
                                
                                    <tr data-href="{{ asset('dashboard/products') }}/{{ $product->id_product  }}/{{ $product->slug_product  }}" @foreach($stocks as $stock)
                                        @if($product->id_product == $stock->id_product)
                                            @if( $stock->stock == 0)
                                                style="color:red";
                                            @endif
                                        @endif
                                    @endforeach>
                                        <td style="width: 5%; text-align: center">{{ $product->id_product }}</td>

                                        <td style="width: 5%">
                                            <img src="{{ $product->img }}" alt="null" style="width: 100%">
                                        </td>

                                        <td>
                                            {{ $product->name_product }}
                                            <br>
                                            @if($product->status == 'false')
                                                <b style="color: red">
                                                    (Ẩn)
                                                </b>
                                            @endif
                                        </td>

                                        <td style="width: 15%; text-transform: uppercase">{{ $product->name_product_type}}</td>

                                        @foreach($stocks as $stock)
                                            @if($product->id_product == $stock->id_product)
                                                <td style="width: 10%">{{ $stock->stock }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
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
                        {{ $products->links() }}
                    </div>
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection





@section('js')
    <script>
        $('.c ').addClass('menu-open');
        $('.c > .nav-link').addClass('active');
        $('.c .nav-treeview #products').addClass('active');
        
        $('.list tr').click(function(){
            window.location = $(this).data("href");
        });

        $("#filterByCate input[name='filterByCate']").click(function(){
            var cate = $('input:radio[name=filterByCate]:checked').val();
            $('#filterByCate').attr('action', '{{ asset("dashboard/products/filter/category=") }}'+cate);
            $('#filterByCate').submit()
        });

        $("#filterByStatus input[name='filterByStatus']").click(function(){
            var status = $('input:radio[name=filterByStatus]:checked').val();
            $('#filterByStatus').attr('action', '{{ asset("dashboard/products/filter/status=") }}'+status);
            $('#filterByStatus').submit()
        });
        
        $('#key').keyup(function(){
            var key = $('#key').val();
            $('#formSearch').attr('action', '{{ asset("dashboard/products/search=") }}'+key);
        });

        $('#add').on('click', function(e) {
            e.stopPropagation();
        });


    </script>
@endsection
