@extends('layouts.themeAdmin')
@section('title', 'Tums | Quản lí kho')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Quản lí kho</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Quản lí kho</li>
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
                        <a href="{{ asset('dashboard/products') }}" style="color: white">Xem sản phẩm</a>
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
                                <form action="{{ asset('dashboard/suppliers/') }}" method="POST" id="formSearch">
                                    @csrf
                                    <input type="text"  id="search" value="" placeholder="Theo mã, tên nhà cung cấp" autocomplete="off" required>
                                </form>
                                @isset($key)
                                    <span>Từ khoá cho :
                                        <b>{{ $key }}</b>
                                    </span>
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
                                <label>
                                    <input type="radio" checked="checked" name="radio"> Bán hàng
                                </label>
                                <label>
                                    <input type="radio" name="radio"> Thu chi
                                </label>
                                <label>
                                    <input type="radio" name="radio"> Hàng hoá
                                </label>
                                <label>
                                    <input type="radio" name="radio"> Tổng hợp
                                </label>
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
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Cập nhật số lượng</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($product_s_c as $key => $value)
                                    <tr data-product="{{ $value->id_product }}" data-size="{{ $value->id_size }}" data-color="{{ $value->id_color }}">
                                        <td style="width: 5%">
                                            <img src="{{ $value->img }}" alt="image" style="width: 100%">
                                        </td>
                                        <td>
                                            <p>{{ $value->name_product }}</p>
                                            <span>{{ $value->size }}, </span>
                                            <span>{{ $value->color }}</span> 
                                        </td>
                                        <td>
                                            {{ number_format($value->price1,0, ',', '.') }}đ
                                        </td>
                                        <td>
                                            {{ $value->quantity }}
                                        </td>
                                        <td>

                                        </td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
        $('.c .nav-treeview #inventory').addClass('active');

       

    </script>
@endsection
