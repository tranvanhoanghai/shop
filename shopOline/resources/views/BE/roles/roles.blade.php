@extends('layouts.themeAdmin')
@section('title', 'Tums | Quản lí nhân viên')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Phân quyền</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Phân quyền</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">
                    <a href="{{ asset('dashboard/roles/add') }}">
                        <button class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Thêm quyền
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" id="datatable">
                
                <div class="col-lg-12 ">
                    <div class="right ">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Tên quyền</th>
                                    <th>Danh sách quyền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($roles as $key => $role)
                                   <tr>
                                        <td>{{ $role->name }}</td>
                                        <td style="width: 50%">
                                            @php
                                                $data = $role->permissions;
                                                $manager = json_decode($data,true);
                                            @endphp
                                            @foreach($manager as $key => $value)
                                                <p style="background: green; color: white; padding: 5px; border-radius: 5px; display: inline-block;">{{ $key }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($role->id == 1)
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <form action="{{ asset('dashboard/roles/edit') }}/{{ $role->id  }}" method="get" style="display: inline-block">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </form>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#role{{ $role->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                            

                                            <div class="modal" id="role{{ $role->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Xoá quyền</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn có muốn xoá quyền <b>{{ $role->name }}</b> này không ? Thao tác này không thể khôi phục.
                                                        </div>
                                                        <form action="{{ asset('dashboard/roles/delete') }}/{{ $role->id }}" method="post">
                                                            @csrf
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                                                <button type="submit" class="btn btn-danger">Xoá</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                   </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--  {{  $staffs->links()}}  --}}
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
