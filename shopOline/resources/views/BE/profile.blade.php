@extends('layouts.themeAdmin')
@section('title', 'Tums | Profile')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if( $profiles->img == null )
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/photos/1/image_profiles/user_profile.jpg') }}" alt="User profile picture">
                                @else  
                                    <img class="profile-user-img img-fluid img-circle" src="{{ $profiles->img }}" alt="User profile picture">
                                @endif
                            </div>
                    
                            <h3 class="profile-username text-center">{{ $profiles->full_name }}</h3>
                    
                            <p class="text-muted text-center">{{ $profiles->name }}</p>
                            <div class="text-center mb-3">
                                <a id="lfm" class="btn btn-primary" data-input="thumbnail" data-preview="holder" style="cursor: pointer;color: white" >
                                    <b>Thay đổi ảnh</b>
                                </a>
                            </div>
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath">

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Đơn đã bán</b> 
                                        @if($sells->total_sell == null)
                                            <a class="float-right" href="javascript:void(0)">0</a>
                                        @else
                                            <a class="float-right" href="javascript:void(0)">
                                                {{ $sells->total_sell }}
                                            </a>
                                        @endif
                                </li> 
                                <li class="list-group-item">
                                    <b>Đơn đã huỷ</b> 
                                    @if($cancels->total_cancel == null)
                                        <a class="float-right" href="javascript:void(0)">0</a>
                                    @else
                                        <a class="float-right" href="javascript:void(0)">
                                            {{ $cancels->total_cancel }}
                                        </a>
                                    @endif
                                </li>
                                {{-- <li class="list-group-item">
                                    <b>Friends</b> <a class="float-right">0</a>
                                </li> --}}
                            </ul>
                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col-md-2 -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3>Profile</h3>
                        </div>

                        <div class="card-body">
                            <form action="{{ asset('dashboard/profile/update') }}/{{ $profiles->id }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label>Họ tên
                                            <input type="text" class="form-control" name="name" value="{{ $profiles->full_name }}"  placeholder="Nhập tên" autocomplete="off" required>
                                        </label>

                                        <label>Địa chỉ
                                            <input type="text" class="form-control" name="address" value="{{ $profiles->address }}"  placeholder="Nhập địa chỉ" autocomplete="off" required>
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Email
                                            <input type="email" class="form-control" name="email" value="{{ $profiles->email }}"  placeholder="Nhập Email" autocomplete="off" required>
                                        </label>

                                        <label>Số điện thoại
                                            <input type="number" class="form-control" name="phone" value="{{ $profiles->phone }}"  placeholder="Nhập Số điện thoại" autocomplete="off" required>
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <button class="btn btn-primary">Chỉnh sửa</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    {{--  MODAL ERRORS  --}}
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
    <script src="{{ asset('vendor/laravel-filemanager//js/stand-alone-button.js') }}"></script>
    <script>
        $('.z ').addClass('menu-open');
        $('.z > .nav-link').addClass('active');
        $('.z .nav-treeview #profile').addClass('active');

        var route_prefix = "{{ asset('laravel-filemanager') }}";
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>
@endsection
