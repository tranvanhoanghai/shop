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
                    <h1 class="m-0 text-dark">Thêm quyền</h1> 
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Thêm quyền</li>
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
                    <form action="{{ asset('dashboard/roles/add') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Tên Quyền
                                <input type="text" class="form-control" placeholder="Nhập tên quyền" required value="" name="name" autocomplete="off">
                            </label>
                        </div>
                        
                        <label> Phân quyền
                            <div style="border: 1px solid; padding: 20px">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>HỆ THỐNG</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"login-dashboard":true' name="role[]">
                                            Đăng nhập hệ thống
                                        </label>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"sale":true' name="role[]">
                                            Bán hàng
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"act-role":true' name="role[]">
                                            Phân quyền
                                        </label>
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>NHÂN VIÊN</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-user":true' name="role[]">
                                            Xem danh sách nhân viên
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"act-user":true' name="role[]">
                                            Thêm, sửa, xoá nhân viên
                                        </label>
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>SẢN PHẨM</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-product":true' name="role[]">
                                            Xem danh sách sản phẩm
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-product":true' name="role[]">
                                            Thêm, sửa, xoá sản phẩm
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-coupon":true' name="role[]">
                                            Thêm, sửa, xoá  mã giảm giá
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-category":true' name="role[]">
                                            Xem danh mục sản phẩm
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-category":true' name="role[]">
                                            Thêm, sửa, xoá danh mục sản phẩm
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"act-prices":true' name="role[]">
                                            Thiết lập giá
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"view-coupon":true' name="role[]">
                                            Xem mã giảm giá
                                        </label>
                                    </div>
                                </div>

<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>HOÁ ĐƠN</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        
                                        <label>
                                            <input type="checkbox" value='"view-bill-order":true' name="role[]">
                                            Xác nhận đơn hàng
                                        </label>
                                    
                                        <label>
                                            <input type="checkbox" value='"act-bill-order":true' name="role[]">
                                            Cập nhật đơn hàng
                                        </label>
                                        
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-bill-import":true' name="role[]">
                                            Xem Phiếu nhập hàng
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-bill-import":true' name="role[]">
                                            Nhập hàng
                                        </label>
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>ĐỐI TÁC</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-customer":true' name="role[]">
                                            Xem danh sách khách hàng
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-customer":true' name="role[]">
                                            Thêm, sửa, xoá khách hàng
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-suppliers":true' name="role[]">
                                            Xem danh sách nhà cung cấp
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-suppliers":true' name="role[]">
                                            Thêm, sửa, nhà cung cấp
                                        </label>
                                    </div>
                                </div>
<br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>WEB</h4> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-blog":true' name="role[]">
                                                Xem danh sách bài viết
                                        </label>
                                        <label>
                                            <input type="checkbox" value='"act-blog":true' name="role[]">
                                            Thêm, sửa, xoá bài viết
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-contact":true' name="role[]">
                                            Xem danh sách liên hệ
                                        </label>

                                        <label>
                                            <input type="checkbox" value='"act-contact":true' name="role[]">
                                            Xoá liên hệ
                                        </label>
                                    </div>

                                    <div class="col-lg-4">
                                        <label>
                                            <input type="checkbox" value='"view-slide":true' name="role[]">
                                            Xem danh sách slider
                                        </label>
                                    
                                        <label>
                                            <input type="checkbox" value='"act-slide":true' name="role[]">
                                            Thêm, sửa, xoá slider
                                        </label>
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
