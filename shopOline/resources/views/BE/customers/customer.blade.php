@extends('layouts.themeAdmin')
@section('title', 'Tums | Khách hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Khách hàng</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Khách hàng</li>
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
                            Thêm khách hàng
                        </button>
                    </div>

                    <div class="d-inline-block">
                        <button class="btn btn-success" data-toggle="modal" data-target="#import">
                            <i class="fas fa-file-import"></i>
                            Nhập file
                        </button>
                    </div>

                    <div class="d-inline-block">
                        <form action="{{ asset('dashboard/customers/export') }}" method="post">
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
                                <form action="{{ asset('dashboard/customers/') }}" method="POST" id="formSearch">
                                    @csrf
                                    <input type="text"  id="search" @isset($key)value="{{ $key }}"@endisset placeholder="Theo mã, tên khách hàng" autocomplete="off" required>
                                </form>
                                @isset($key)
                                    <div>
                                        <span>Từ khoá cho :
                                            <b>{{ $key }}</b>
                                        </span>
                                        <a href="{{ asset('dashboard/customers') }}" style="float: right"><i class="fas fa-times"></i></a>
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
                                    <option value="10">
                                        10
                                    </option>
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
                                    <th>Mã khách hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Phone</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($customer as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->full_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->address }}</td>
                                        <td>{{ $value->phone }}</td>
                                       
                                        <td style="text-align: center" >

                                            @if($value->id == 2)
                                                {{-- <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button>  --}}
                                                
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button  class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                {{-- <button class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </button> --}}

                                                <button class="btn btn-primary edit" data-id="{{ $value->id }}" data-toggle="modal" data-target="#update">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button  class="btn btn-danger de" data-id="{{ $value->id }}" data-toggle="modal" data-target="#delete" >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                            

                                            <!-- Modal -->
                                            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title">Xoá Khách hàng</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa khách hàng này?
                                                        Thao tác này không thể khôi phục
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="">
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
                    {{  $customer->links()}}
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal ADD-->
    <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Thêm khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    @csrf</form>
                <form action="{{ asset("/dashboard/customers/add/") }}" method="POST">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên khách hàng</label>
                            <input type="text" class="form-control"  placeholder="Tên khách hàng" required name="nameKH" autocomplete="off">
                            
                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control" placeholder="Địa chỉ" required name="address" autocomplete="off">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" placeholder="Email" required name="email" autocomplete="off">
                            
                            <label for="">Số điện thoại</label>
                            <input type="number" class="form-control" placeholder="Số điện thoại" name="phone" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Loại khách hàng</label>
                            <select name="typeKH" class="form-control">
                                @foreach($type as $value)
                                    <option value="{{ $value->id_user_type }}">{{ $value->name_user_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal UPDATE-->
    <div class="modal" id="update" tabindex="-1" role="dialog"aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    @csrf</form>
                <form action="{{ asset("/dashboard/customers/update/") }}" method="POST" id="form">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên khách hàng</label>
                            <input type="text" class="form-control" id="nameKH"  placeholder="Tên khách hàng" required name="nameKH" autocomplete="off">
                            
                            <label for="">Địa chỉ</label>
                            <input type="text" class="form-control" id="address"  placeholder="Địa chỉ" required name="address" autocomplete="off">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" required name="email" autocomplete="off">
                            
                            <label for="">Số điện thoại</label>
                            <input type="number" class="form-control" id="phone" placeholder="Số điện thoại" name="phone" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Loại khách hàng</label>
                            <select name="typeKH" id="typeKH" class="form-control">
                                @foreach($type as $value)
                                    <option value="{{ $value->id_user_type }}">{{ $value->name_user_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
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
                    <h5 class="modal-title">Nhập khách hàng</h5>
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

    <!-- Modal ERRORS-->
    <div class="modal" id="modal" tabindex="-1" role="dialog"  aria-hidden="true">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> {{-- Toast js swal --}}

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
        $('.e .nav-treeview #customers').addClass('active');

        $('#search').keyup(function(){
            var key =  $('#search').val();
            $('#formSearch').attr('action', '{{ asset("/dashboard/customers/search") }}=' +key);
        });
        
        $('.edit').click(function(){
            var id = $(this).data('id');
            $('#form').attr('action','{{ asset("/dashboard/customers/update") }}/'+ id);
   
            $.ajax({
                url :'{{ asset("/dashboard/customers/edit") }}/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                success: function(data) {
                    console.log(data.user);
                    for (var i = 0; i < data.user.length; i++) {
                        $('#nameKH').val(data.user[i].full_name);
                        $('#email').val(data.user[i].email);
                        $('#address').val(data.user[i].address);
                        $('#phone').val(data.user[i].phone);

                        var name = data.user[i].name_user_type;
                        $('#typeKH').find('option').each(function(i,e){
                            if($(e).text() == name){
                                $('#typeKH').prop('selectedIndex',i);
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
                    url :'{{ asset("/dashboard/customers/delete") }}/' + id,
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
        });
        
    </script>
@endsection
