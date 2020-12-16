@extends('layouts.themeAdmin')
@section('title', 'Tums | Slider')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Slider</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Slider</li>
                    </ol>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    
                        <button class="btn btn-success" data-toggle="modal" data-target="#add">
                            Thêm ảnh sản phẩm
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
                
                <div class="col-lg-12">
                    <div class="right">
                        <table class="">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Hình ảnh</th>
                                    <th>Link</th>
                                    <th>Content</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                               @forelse($sliders as $key => $slider)
                                   <tr>
                                       <td style="width: 5%;text-align: center">{{ $key+1 }}</td>
                                       <td style="width: 10%">
                                            <img src="{{ $slider->img }}" alt="" style="width: 100%"> 
                                        </td>
                                        <td style="width: 30%;text-align: center">
                                            <a href="{{ asset($slider->link) }}">{{ asset($slider->link) }}</a>
                                        </td>
                                        <td>{{ $slider->content }}</td>
                                        <td style="width: 5%">
                                            @if($slider->status=='true')
                                                Hiển thị
                                            @else
                                                Ẩn
                                            @endif
                                        </td>
                                        <td style="width: 10%">
                                            <button class="btn btn-primary edit" data-toggle="modal" data-target="#update" data-id="{{ $slider->id_slider }}" data-link="{{ $slider->link }}" data-content="{{ $slider->content }}" data-status="{{ $slider->status }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="{{ $slider->id_slider }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                   </tr>
                               @empty
                                   <tr>
                                       <td colspan="6" class="text-center">Không có kết quả hiển thị</td>
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

    {{-- MODAL ADD --}}
    <div class="modal" id="add" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Thêm Slider</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('dashboard/sliders/add') }}" method="post">
                @csrf
                <div class="modal-body">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" >
                        <button type="button" class="btn btn-primary">
                                Chọn ảnh
                        </button>
                    </a>

                    <input id="thumbnail" class="form-control" type="hidden" name="filepath" required>
                    <div class="" id="holder">
                        <img  style="margin: 10px !important">
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

    {{-- MODAL UPDATE --}}
    <div class="modal" id="update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Sửa Slider</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('dashboard/sliders/update') }}" method="post" id="formUpdate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <a id="lfm1" data-input="thumbnail1" data-preview="holder1" >
                            <button type="button" class="btn btn-primary">
                                    Chọn ảnh
                            </button>
                        </a>
    
                        <input id="thumbnail1" class="form-control" type="hidden" name="filepath1">
                        <div id="holder1">
                            <img >
                        </div>

                        <label>Đường dẫn
                            <input type="text" class="form-control"  placeholder="Nhập đường dẫn" name="link" id="link">
                        </label>

                        <label>Nội dung
                            <input type="text" class="form-control"  placeholder="Nhập nội dung" name="content" id="content">
                        </label>

                        <select name="status" class="form-control" id="upStatusSlider">
                            <option value="true">Hiển thị</option>
                            <option value="false">Ẩn</option>
                        </select>

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

    {{-- MODAL DELETE --}}
    <div class="modal" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Xoá Slider</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('dashboard/sliders/delete') }}" method="post" id="formDelete">
                @csrf
                <div class="modal-body">
                    Bạn có muốn xoá slider này không ? Thao tác này không phục hồi
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-danger">Xoá</button>
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
        $('.f ').addClass('menu-open');
        $('.f > .nav-link').addClass('active');
         $('.f .nav-treeview #sliders').addClass('active');
        
        var route_prefix = "{{ asset('laravel-filemanager') }}";
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
        $('#lfm').filemanager('image', {prefix: route_prefix});
        $('#lfm1').filemanager('image', {prefix: route_prefix});

        $('.edit').click(function(){
            var id = $(this).data('id');
            var status = $(this).data('status');

            $('#formUpdate').attr('action', '{{ asset("dashboard/sliders/update") }}/'+id);
            $('#link').val($(this).data('link'));
            $('#content').val($(this).data('content'));

            if(status == true){
                $('#upStatusSlider').find('option').each(function(i,e){
                    $('#upStatusSlider').prop('selectedIndex',0);
                });
            }else{
                $('#upStatusSlider').find('option').each(function(i,e){
                    $('#upStatusSlider').prop('selectedIndex',1);
                });
            }

        });

        $('.delete').click(function(){
            var id = $(this).data('id');
            $('#formDelete').attr('action', '{{ asset("dashboard/sliders/delete") }}/'+id);
        });
       

       

    </script>
@endsection
