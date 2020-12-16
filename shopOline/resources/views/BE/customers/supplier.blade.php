@extends('layouts.themeAdmin')
@section('title', 'Tums | Nhà cung cấp')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Nhà cung cấp</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Nhà cung cấp</li>
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
                        <form action="{{ asset('dashboard/suppliers/export') }}" method="post">
                            @csrf
                            <button class="btn btn-success">
                                <i class="fas fa-file-export"></i>
                                Xuất file
                            </button>
                        </form>
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
                                <form action="{{ asset('dashboard/suppliers/') }}" method="POST" id="formSearch">
                                    @csrf
                                    <input type="text"  id="search" @isset($key)value="{{ $key }}"@endisset placeholder="Theo mã, tên nhà cung cấp" autocomplete="off" required>
                                </form>
                                @isset($key)
                                    <div>
                                        <span>Từ khoá cho :
                                            <b>{{ $key }}</b>
                                        </span>
                                        <a href="{{ asset('dashboard/suppliers') }}" style="float: right"><i class="fas fa-times"></i></a>
                                    </div>
                                @endisset
                            </div>
                        </div>

                        {{-- <div class="card card-primary">
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
                        </div> --}}

                        {{-- <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Lựa chọn hiển thị</h3>
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
                        </div> --}}
                    </div>
                </div>
                <!-- /.col-md-2 -->
                <div class="col-lg-10 ">
                    <div class="right ">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Mã nhà cung cấp</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Phone</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($supplier as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->full_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->address }}</td>
                                        <td>{{ $value->phone }}</td>
                                    
                                    
                                        <td style="text-align: center">
                                            <button class="btn btn-success">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-primary edit"data-id="{{ $value->id }}" data-toggle="modal" data-target="#update">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button  class="btn btn-danger de" data-id="{{ $value->id }}"data-toggle="modal" data-target="#delete" >
                                                <i class="fas fa-trash"></i>
                                            </button>

                                                <!-- Modal -->
                                            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Xoá nhà cung cấp</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="" >
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-danger delete" data-dismiss="modal">Xoá</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            Dữ liệu trống
                                        </td>
                                    </tr> 
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{  $supplier->links()}}
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    {{-- MODAL ADD --}}
    <div class="modal fade" id="add" tabindex="-1" role="dialog"aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Thêm nhà cung cấp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ asset('dashboard/suppliers/add') }}" method="POST">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên nhà cung cấp</label> 
                            <input type="text" class="form-control" value="{{ old('nameNCC') }}"required  placeholder="Tên khách hàng"  name="nameNCC">

                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control" value="{{ old('addressNCC') }}" required placeholder="Địa chỉ"  name="addressNCC">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" value="{{ old('emailNCC') }}" required placeholder="Email"  name="emailNCC">

                            <label for="">Số điện thoại</label>
                            <input type="number"  class="form-control"value="{{ old('phoneNCC') }}"required placeholder="Số điện thoại"  name="phoneNCC">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="">Loại nhà cung cấp</label>
                            <select name="typeNCC" id="typeNCC" class="form-control">
                                @foreach($type as $value)
                                    <option value="{{ $value->id_user_type }}">{{ $value->name_user_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL UPDATE --}}
    <div class="modal fade" id="update" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Cập nhật nhà cung cấp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ asset('') }}" method="POST" id="form">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên nhà cung cấp</label>
                            <input type="text" class="form-control"name="upNameNCC" id="upNameNCC" value="{{ old('upNameNCC') }}" placeholder="Tên khách hàng" required >

                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control"name="upAddressNCC"id="upAddressNCC" value="{{ old('upAddressNCC') }}"  placeholder="Địa chỉ" required >
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="upEmailNCC"id="upEmailNCC" value="{{ old('upEmailNCC') }}" placeholder="Email" required>

                            <label for="">Số điện thoại</label>
                            <input type="number" class="form-control"name="upPhoneNCC"id="upPhoneNCC" value="{{ old('upPhoneNCC') }}"  placeholder="Số điện thoại" required >
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="">Loại nhà cung cấp</label>
                            <select name="uptypeNCC" id="uptypeNCC" class="form-control">
                                @foreach($type as $value)
                                    <option value="{{ $value->id_user_type }}">{{ $value->name_user_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                    <h5 class="modal-title">Nhập nhà cung cấp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/customers/import') }}" method="post" enctype="multipart/form-data">
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

    {{-- MODAL ERRORS --}}
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
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
        $('.e ').addClass('menu-open');
        $('.e > .nav-link').addClass('active');
        $('.e .nav-treeview #suppliers').addClass('active');


        $('#search').keyup(function(){
            var key =  $('#search').val();
            $('#formSearch').attr('action', '{{ asset("/dashboard/suppliers/search") }}=' +key);
        });


        $('.edit').click(function(){
            var id = $(this).data('id');
            $('#form').attr('action','{{ asset("/dashboard/suppliers/update") }}/'+ id);
   
            $.ajax({
                url :'{{ asset("/dashboard/suppliers/edit") }}/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                success: function(data) {
                    for (var i = 0; i < data.user.length; i++) {
                        $('#upNameNCC').val(data.user[i].full_name);
                        $('#upEmailNCC').val(data.user[i].email);
                        $('#upAddressNCC').val(data.user[i].address);
                        $('#upPhoneNCC').val(data.user[i].phone);

                        var b = data.user[i].name_user_type;
                        $('#uptypeNCC').find('option').each(function(i,e){

                            if($(e).text() == b){
                                $('#uptypeNCC').prop('selectedIndex',i);
                            }
                        });
                    }
                }
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $('.de').click(function(){
            var id = $(this).data('id');
            var c_obj = $(this).parents("tr");
            $('.delete').click(function(){

                $.ajax({
                    url :'{{ asset("/dashboard/suppliers/delete") }}/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "post",
                    success: function(data) {
                        c_obj.remove();
                        Toast.fire({
                            position: 'top-end',
                            icon: 'success',
                            text: 'Xoá thành công',
                        })
                    }
                });
            });
        })

    </script>
@endsection
