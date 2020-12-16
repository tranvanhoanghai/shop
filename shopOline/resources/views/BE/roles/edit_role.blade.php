@extends('layouts.themeAdmin')
@section('title', 'Tums | Quản lí nhân viên')
@section('style')
<style>
    label{
        cursor: pointer;
    }
</style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Chỉnh sửa quyền</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Chỉnh sửa quyền</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid" style="background: white;padding: 20px;box-shadow: 0 0 0 1px rgba(63,63,68,.05), 0 1px 3px 0 rgba(63,63,68,.15);">
            <div class="row" >
                <div class="col-lg-12">
                    <form action="{{ asset('dashboard/roles/update') }}/{{ $id }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Tên Quyền
                                <input type="text" class="form-control" placeholder="Nhập tên quyền" required value="{{ $roles->name }}" name="name">
                            </label>
                        </div>
                        
                        <label> Phân quyền
                            <div style="border: 1px solid; padding: 20px">
                                @php
                                    $data = $roles->permissions;
                                @endphp

                                <div class="row">
                                    <div class="col-12">
                                        <h4>HỆ THỐNG</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if (strlen(strstr($data, 'login-dashboard')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"login-dashboard":true' name="role[]" checked>
                                                Đăng nhập hệ thống
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"login-dashboard":true' name="role[]">
                                                Đăng nhập hệ thống
                                            </label>
                                        @endif
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        @if (strlen(strstr($data, 'sale')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"sale":true' name="role[]" checked>
                                                Bán hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"sale":true' name="role[]">
                                                Bán hàng
                                            </label>
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        @if (strlen(strstr($data, 'act-role')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-role":true' name="role[]" checked>
                                                Phân quyền
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-role":true' name="role[]">
                                                Phân quyền
                                            </label>
                                        @endif
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>NHÂN VIÊN</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-user')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-user":true' name="role[]" checked>
                                                Xem danh sách nhân viên
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-user":true' name="role[]">
                                                Xem danh sách nhân viên
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'act-user')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-user":true' name="role[]" checked>
                                                Thêm, sửa, xoá nhân viên
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-user":true' name="role[]">
                                                Thêm, sửa, xoá nhân viên
                                            </label>
                                        @endif
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>SẢN PHẨM</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-product')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-product":true' name="role[]" checked>
                                                Xem danh sách sản phẩm
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-product":true' name="role[]">
                                                Xem danh sách sản phẩm
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-product')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-product":true' name="role[]" checked>
                                                Thêm, sửa, xoá sản phẩm
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-product":true' name="role[]">
                                                Thêm, sửa, xoá sản phẩm
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-coupon')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-coupon":true' name="role[]" checked>
                                                Thêm, sửa, xoá mã giảm giá
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-coupon":true' name="role[]">
                                                Thêm, sửa, xoá mã giảm giá
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-category')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-category":true' name="role[]" checked>
                                                Xem danh mục sản phẩm
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-category":true' name="role[]">
                                                Xem danh mục sản phẩm
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-category')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-category":true' name="role[]" checked>
                                                Thêm, sửa, xoá danh mục sản phẩm
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-category":true' name="role[]">
                                                Thêm, sửa, xoá danh mục sản phẩm
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'act-prices')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-prices":true' name="role[]" checked>
                                                Thiết lập giá
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-prices":true' name="role[]">
                                                Thiết lập giá
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'view-coupon')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-coupon":true' name="role[]" checked>
                                                Xem mã giảm giá
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-coupon":true' name="role[]">
                                                Xem mã giảm giá
                                            </label>
                                        @endif
                                    </div>
                                </div>

<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>HOÁ ĐƠN</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-bill-order')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-bill-order":true' name="role[]" checked>
                                                Xác nhận đơn hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-bill-order":true' name="role[]">
                                                Xác nhận đơn hàng
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-bill-order')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-bill-order":true' name="role[]" checked>
                                                Cập nhật đơn hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-bill-order":true' name="role[]">
                                                Cập nhật đơn hàng
                                            </label>
                                        @endif
                                        
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-bill-import')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-bill-import":true' name="role[]" checked>
                                                Xem Phiếu nhập hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-bill-import":true' name="role[]">
                                                Xem Phiếu nhập hàng
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-bill-import')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-bill-import":true' name="role[]" checked>
                                                Nhập hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-bill-import":true' name="role[]">
                                                Nhập hàng
                                            </label>
                                        @endif
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>ĐỐI TÁC</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-customer')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-customer":true' name="role[]" checked>
                                                Xem danh sách khách hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-customer":true' name="role[]">
                                                Xem danh sách khách hàng
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-customer')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-customer":true'name="role[]" checked>
                                                Thêm, sửa, xoá khách hàng
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-customer":true' name="role[]">
                                                Thêm, sửa, xoá khách hàng
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-suppliers')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-suppliers":true' name="role[]" checked>
                                                Xem danh sách nhà cung cấp
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-suppliers":true' name="role[]">
                                                Xem danh sách nhà cung cấp
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-suppliers')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-suppliers":true' name="role[]" checked>
                                                Thêm, sửa, nhà cung cấp
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-suppliers":true' name="role[]">
                                                Thêm, sửa, nhà cung cấp
                                            </label>
                                        @endif
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>WEB</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-blog')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-blog":true' name="role[]" checked>
                                                Xem danh sách bài viết
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-blog":true' name="role[]">
                                                 Xem danh sách bài viết
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-blog')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-blog":true' name="role[]" checked>
                                                Thêm, sửa, xoá bài viết
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-blog":true' name="role[]">
                                                Thêm, sửa, xoá bài viết
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-contact')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-contact":true' name="role[]" checked>
                                                Xem danh sách liên hệ
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-contact":true' name="role[]">
                                                Xem danh sách liên hệ
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-contact')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-contact":true' name="role[]" checked>
                                                Xoá liên hệ
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-contact":true' name="role[]">
                                                Xoá liên hệ
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        @if(strlen(strstr($data, 'view-slide')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"view-slide":true' name="role[]" checked>
                                                Xem danh sách slider
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"view-slide":true' name="role[]">
                                                Xem danh sách slider
                                            </label>
                                        @endif

                                        @if(strlen(strstr($data, 'act-slide')) > 0) 
                                            <label>
                                                <input type="checkbox" value='"act-slide":true' name="role[]" checked>
                                                Thêm, sửa, xoá slider
                                            </label>
                                        @else 
                                            <label>
                                                <input type="checkbox" value='"act-slide":true' name="role[]">
                                                Thêm, sửa, xoá slider
                                            </label>
                                        @endif
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <button class="btn btn-primary">Lưu</button>
                                </div>
                            </div>

                        </label>
                    </form>
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

     <!-- Modal ADD-->
    {{-- <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset("/dashboard/staffs/add") }}" method="post" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Tên nhân viên
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Tên nhân viên">
                            </label>
                            <label> Email
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
                            </label>
                            <label> Số điện thoại
                                <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Số điện thoại">
                            </label>
                            <label> Địa chỉ
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}" required placeholder="Địa chỉ">
                            </label>
                            <label> Phân quyền
                                <select name="role" class="form-control" required>
                                    @foreach($roles as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}


    <!-- Modal DELETE-->
    {{-- <div class="modal" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xoá nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="deleteStaff">
                    @csrf
                    <div class="modal-body">
                        <p style="font-size: 18px">Bạn có chắc muốn xoá nhân viên <b></b> này không? Thao tấc này không thể khôi phục</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button class="btn btn-danger">Xoá</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    
    {{-- MODAL ERRORS  --}}
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
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
        $('.z ').addClass('menu-open');
        $('.z > .nav-link').addClass('active');
        $('.z .nav-treeview #roles').addClass('active');     

    </script>
@endsection
