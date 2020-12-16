@extends('layouts.themeAdmin')
@section('title', 'Tums | Danh mục sản phẩm')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Danh mục sản phẩm</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Danh mục sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">

                    <div class="d-inline-block">
                        <button class="btn btn-success" data-toggle="modal" data-target="#add">
                            <i class="fas fa-plus"></i>
                            Thêm mới
                        </button>
                    </div>

                    <div class="d-inline-block">
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
                    </div>
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
                                <form action="" id="formSearch" method="post">
                                    @csrf
                                    <input type="text"  name="search" id="key" placeholder="Theo mã, tên danh mục" autocomplete="off" required>
                                </form>

                                @isset($key)
                                    <div class="fil-active">
                                        <span style="margin-right: 10px">
                                            {{ $key }}
                                            <a href="{{ asset('dashboard/categorys') }}" style="float: right">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    </div>
                                @endisset
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
                                <form action="{{ asset('dashboard/categorys/filter') }}" method="post" id="filterByStatus">
                                    @csrf
                                    @isset($status)
                                        @if($status == 1)
                                            <label>
                                                <input type="radio"  name="filterByStatus" value="1" checked> Hiện 
                                                <a href="{{ asset('dashboard/categorys') }}" style="float: right">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </label>
                                            <label>
                                                <input type="radio"  name="filterByStatus" value="0"> Ẩn
                                            </label>
                                        @else
                                            <label>
                                                <input type="radio"  name="filterByStatus" value="1"> Hiện 
                                            </label>
                                            <label>
                                                <input type="radio"  name="filterByStatus" value="0" checked> Ẩn
                                                <a href="{{ asset('dashboard/categorys') }}" style="float: right">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </label>
                                        @endif
                                    @endisset

                                    @if(!isset($status))
                                        <label>
                                            <input type="radio"  name="filterByStatus" value="1"> Hiện
                                        </label>
                                        <label>
                                            <input type="radio"  name="filterByStatus" value="0"> Ẩn
                                        </label>
                                    @endif
                                </form>
                                
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
                                    <th>Mã danh mục</th>
                                    <th>Danh mục</th>
                                    <th>Trạng thái</th>
                                    <th style="text-align: center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($categorys as $category)
                                    <tr>
                                        <td>{{ $category->id_product_type  }}</td>
                                        <td>
                                            {{ $category->name_product_type  }}
                                        </td>
                                        <td>
                                            @if($category->status == 1)
                                                Hiện
                                            @else
                                                Ẩn
                                            @endif
                                        </td>
                                        <td style="text-align: center" >
                                            <button class="btn btn-primary edit" data-toggle="modal" data-target="#update" data-id="{{ $category->id_product_type  }}" data-name="{{ $category->name_product_type  }}" data-status="{{ $category->status  }}">
                                                <i class="far fa-edit"></i>
                                            </button>

                                            <button class="btn btn-danger delete" data-toggle="modal" data-target="#deleteCate" data-id="{{ $category->id_product_type  }}" data-name="{{ $category->name_product_type  }}">
                                                    <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                   <tr>
                                       <td colspan="4" style="padding: 20px;text-align: center">
                                           <h4>
                                                Không tìm thấy kết quả phù hợp
                                           </h4>
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

  
    <!-- Modal add -->
    <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/categorys/add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên danh mục
                                <input type="text" class="form-control" placeholder="Tên danh mục" name="nameCate" required>
                            </label>

                            <label>Trạng thái
                                <select name="statusCate" class="form-control" style="color: black">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-success">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal update-->
    <div class="modal" id="update" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/categorys/update') }}" method="POST" id="formUpdate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên danh mục
                                <input type="text" class="form-control" placeholder="Tên danh mục" name="upNameCate" id="upNameCate">
                            </label>

                            <label>Trạng thái
                                <select name="upStatusCate" id="upStatusCate" class="form-control" style="color: black">
                                    <option value="1" >Hiện</option>
                                    <option value="0" slected>Ẩn</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal delete-->
    <div class="modal" id="deleteCate" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xoá danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/categorys/delete') }}" method="POST" id="formDelete">
                    @csrf
                    <div class="modal-body">
                        <span style="font-size: 19px">
                            Thao tác này sẽ xóa danh mục <b id="getName"></b>, Kèm theo những sản phẩm thuộc danh mục này cũng bị xoá. Thao tác này không thể khôi phục.
                        </span>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger">Xoá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    {{-- MODAL IMPORT --}}
    <div class="modal" id="import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nhập danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/categorys/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        
                        <input type="file" name="file" accept=".xlsx" value="">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EXPORT --}}
    <div class="modal" id="export" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xuất danh sách danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/categorys/export') }}" method="post"> 
                    @csrf
                    <div class="modal-body">
                        Xuất file?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xuất</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL MESSAGE --}}
    <div class="modal" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
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
        $('.c .nav-treeview #categorys').addClass('active');


        $('.edit').click(function(){
            var id = $(this).data('id');
            var status = $(this).data('status');

            $('#upNameCate').val($(this).data('name'));
            if(status == 1){
                $('#upStatusCate').find('option').each(function(i,e){
                    $('#upStatusCate').prop('selectedIndex',0);
                });
            }else{
                $('#upStatusCate').find('option').each(function(i,e){
                    $('#upStatusCate').prop('selectedIndex',1);
                });
            }
            $('#formUpdate').attr('action', '{{ asset("dashboard/categorys/update") }}/'+id);
        });

        $('.delete').click(function(){
            var id = $(this).data('id');
            $('#getName').text($(this).data('name'));
            $('#formDelete').attr('action', '{{ asset("dashboard/categorys/delete") }}/'+id);
        });

        $("#filterByStatus input[name='filterByStatus']").click(function(){
            var status = $('input:radio[name=filterByStatus]:checked').val();
            $('#filterByStatus').attr('action', '{{ asset("dashboard/categorys/filter/status=") }}'+status);
            $('#filterByStatus').submit()
        });

        $('#key').keyup(function(){
            var key = $('#key').val();
            $('#formSearch').attr('action', '{{ asset("dashboard/categorys/search=") }}'+key);
        });


    </script>
@endsection
