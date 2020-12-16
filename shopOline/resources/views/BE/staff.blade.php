@extends('layouts.themeAdmin')
@section('title', 'Tums | Quản lí nhân viên')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Quản lí nhân viên</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Quản lí nhân viên</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">

                    <button class="btn btn-success" data-toggle="modal" data-target="#add">
                        <i class="fas fa-plus"></i>
                        Thêm nhân viên 
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
                                <form action="{{ asset('dashboard/staffs/search') }}" method="POST" id="formSearch">
                                    @csrf
                                    <input type="text" id="search" value="" placeholder="Theo tên nhân viên" autocomplete="off">
                                </form>
                                @isset($key)
                                    <div style="background: #dfe4e8;padding: 10px;margin-top: 10px;">
                                        <span>
                                           {{ $key }}
                                        </span>
                                        <a href="{{ asset('dashboard/staffs/') }}" style="float: right"><i class="fas fa-times"></i></a>
                                    </div>
                                @endisset
                                
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
                                    <th>Mã nhân viên</th>
                                    <th>Tên nhân viên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Quyền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($staffs as $staff)
                                    <tr>
                                        <td>{{ $staff->id }}</td>
                                        <td>{{ $staff->full_name }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>{{ $staff->phone}}</td>
                                        <td>{{ $staff->address}}</td>
                                        @foreach($roles as  $role)
                                            @foreach($user_roles as  $value)
                                                @if($staff->id == $value->user_id && $role->id == $value->role_id)
                                                    <td>{{ $role->name}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <td>
                                            <button class="btn btn-primary edit" data-toggle="modal" data-target="#update"  data-id="{{ $staff->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-danger delete"data-toggle="modal" data-target="#delete"  data-id="{{ $staff->id }}" data-name="{{ $staff->full_name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="padding: 20px;text-align: center">
                                            <h4>
                                                Không tìm thấy kết quả phù hợp
                                            </h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{  $staffs->links()}}
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset("/dashboard/staffs/add") }}" method="post" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Tên nhân viên
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Tên nhân viên" autocomplete="off">
                            </label>
                            <label> Email
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="off">
                            </label>
                            <label> Số điện thoại
                                <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Số điện thoại" autocomplete="off">
                            </label>
                            <label> Địa chỉ
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}" required placeholder="Địa chỉ" autocomplete="off">
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
    </div>

    <!-- Modal UPDATE-->
    <div class="modal" id="update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin nhân viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="upStaff">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Tên nhân viên
                                <input type="text" class="form-control" placeholder="Tên nhân viên" id="name" name="name" required autocomplete="off">
                            </label>
                            <label> Email
                                <input type="text" class="form-control" placeholder="Email" id="email" name="email" required autocomplete="off">
                            </label>
                            <label> Số điện thoại
                                <input type="number" class="form-control" placeholder="Số điện thoại" id="phone" name="phone" required autocomplete="off">
                            </label>
                            <label> Địa chỉ
                                <input type="text" class="form-control" placeholder="Địa chỉ" id="address" name="address" required autocomplete="off">
                            </label>
                            <label> Phân quyền
                                <select name="role" id="role" class="form-control" required></select>
                            </label>
                            <label> Số đơn đã bán
                                <input type="number" class="form-control" id="sell" disabled >
                            </label>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Đóng</button>
                        <button class="btn btn-primary" disabled>Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal DELETE-->
    <div class="modal" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xoá nhân viên</h5>
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
    </div>
    
    {{--  MODAL ERRORS  --}}
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
        $('.z ').addClass('menu-open');
        $('.z > .nav-link').addClass('active');
        $('.z .nav-treeview #staffs').addClass('active');

        $('.edit').click(function(){
            var id = $(this).data('id');
            $('#upStaff').attr('action','{{ asset("dashboard/staffs/update") }}/'+id);
            
            $.ajax({
                url :'{{ asset("/dashboard/staffs/edit") }}/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                success: function(data) {
                    
                   $('#name').val(data.staffs.full_name);
                   $('#email').val(data.staffs.email);
                   $('#phone').val(data.staffs.phone);
                   $('#address').val(data.staffs.address);
                   $('#sell').val(data.sell.total_sell);

                   var content = "";
                   for (var i = 0; i < data.roles.length; i++) {
                       
                        if(data.role_user.role_id == data.roles[i].id){
                            content+="<option value='"+data.roles[i].id+"' selected>" 
                                    + data.roles[i].name 
                                    + "</option>";
                        }else{
                            content+="<option value='"+data.roles[i].id+"'>" 
                                    + data.roles[i].name 
                                    + "</option>";
                        }
                    }
                    $('#role').html(content);
                }
            });
        });

        $('.delete').click(function(){
            var id = $(this).data('id');
            $('#deleteStaff').attr('action','{{ asset("dashboard/staffs/delete") }}/'+id);
            $('#deleteStaff b').text($(this).data('name'));
        });

        $('#search').keyup(function(){
            var key = $('#search').val();
            $('#formSearch').attr('action','{{ asset("dashboard/staffs/search") }}='+key);
        });

        $('#upStaff input').keyup(function(){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode != '32' ){
                $('.btn-primary').prop("disabled", false);
            }
        });
        
        $("#role").change(function(){
            $('.btn-primary').prop("disabled", false);
        });
    </script>
@endsection
