@extends('layouts.themeAdmin')
@section('title',  "Tums | Thêm mới ản phẩm")

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row" id="datatable">
                <div class="col-md-12">
                    <h6>
                        <a href="{{ asset('dashboard/products/') }}" class="">
                            <i class="fas fa-chevron-left"></i>    
                            Quay lại danh sách sản phẩm
                        </a>
                    </h6>
                    <span style="font-weight: 500;font-size: 30px">
                        Thêm mới sản phẩm
                    </span>
                </div>
            </div>

            <br>

            <form action="{{ asset('dashboard/products/create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="ss1">
                            <label>Tên sản phẩm
                                <input class="form-control" type="text" name="createName" value="{{ old('createName') }}" placeholder="Nhập nội dung tên sản phẩm" required autocomplete="off">
                            </label>

                            <div class="form-group">
                                <label for="editor1">Mô tả</label>
                                <textarea class="form-control ckeditor" rows="3" name="createDescription"></textarea>
                            </div>
                        </div>

                        <div class=" ss1-image ss1">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5 style="font-weight: 600">Ảnh sản phẩm</h5>
                                </div>
        
                                <div class="col-md-5 text-right">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" style="cursor: pointer;color: #328af1" >
                                        Thêm ảnh sản phẩm
                                    </a>
                                    <input id="thumbnail" class="form-control" type="hidden" name="filepath" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-sm-12 col-12" id="holder">
                                    <img>
                                </div>
                            </div>
                        </div>

                        <div class="ss1 ss1-price" style="margin-top: 20px">
                            <div class="">
                                <h5 style="font-weight: 600">Giá sản phẩm</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label >Giá vốn
                                        <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price0" min="10000" value="{{ old('price0') }}" required>
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label >Giá sản phẩm
                                        <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price1" value="{{ old('price1') }}" required>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="ss1 ss1-property">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5 style="font-weight: 600">Thuộc tính</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Màu sắc</th>
                                                <th>Số lượng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control size" name="size[]" id="size" required>
                                                        @foreach($sizes as $key => $size)
                                                            <option value="{{ $size->id_size }}">{{ $size->size }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control color" name="color[]" id="color[]" required>
                                                        @foreach($colors as $key => $color)
                                                            <option value="{{ $color->id_color }}">{{ $color->color }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="number" min="0" max="0" name="qty[]" value="0" readonly></td>
                                                <td>
                                                    <button id="addProperty" class="btn btn-primary" type="button">
                                                        Thêm thuộc tính
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="ss1 ss2-status">
                            <div class="">
                                <h5 style="font-weight: 600">Trạng thái</h5>
                            </div>
                            <div>
                                <label > 
                                    <input type="radio" name="status" id="" checked value="true">
                                    Hiển thị
                                </label>

                                </label>
                                    <input type="radio" name="status" id="" value="false">
                                    Ẩn
                                </label>
                            </div>
                        </div>

                        <div class="ss1 ss2-type" style="margin-top: 20px">
                            <div class="">
                                <h5 style="font-weight: 600">Phân loại</h5>
                            </div>

                            <div class="form-group">
                                <label for="type">Danh mục</label>
                                <select class="form-control" id="type" style="text-transform: uppercase" name="type">
                                    @foreach($categorys as $category)
                                        <option value="{{ $category->id_product_type  }}" >
                                            {{ $category->name_product_type }}
                                        </option>
                                    @endforeach
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="type">Đơn vị tính</label>
                                <select class="form-control" id="type" style="text-transform: uppercase" name="unit">
                                    <option value="Cái" >
                                        Cái
                                    </option>
                                    <option value="Bộ">
                                        Bộ
                                    </option>
                                    <option value="Đôi">
                                        Đôi
                                    </option>
                                </select>
                              </div>
                        </div>
                    </div>

                </div>

                <div class="row" style="margin-top: 50px;border-top: 1px solid #bbb; padding: 20px 0">
                    <div class="col-6 ml-auto" style="text-align: right">
                        <a href="{{ asset('dashboard/products') }}">
                            <button class="btn btn-outline-secondary" type="button">
                                Huỷ
                            </button>
                        </a>
                        <button class="btn btn-primary save" type="submit">
                            Lưu
                        </button>
                    </div>
                </div>

            </form>
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
        $('.c .nav-treeview #products').addClass('active');

        var route_prefix = "{{ asset('laravel-filemanager') }}";
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
        $('#lfm').filemanager('image', {prefix: route_prefix});

        $('#addProperty').click(function(){
            var html="";
            html +='<tr>';
            html +='<td>'
                    +'<select class="form-control size" name="size[]">'
                        +'@foreach($sizes as $key => $size)'
                            + '<option value="{{ $size->id_size }}">{{ $size->size }}</option>'
                        + '@endforeach'
                    +'</select>'
                +'</td>';

            html +='<td>'
                    +'<select class="form-control color" name="color[]">'
                        +'@foreach($colors as $key => $color)'
                        + '<option value="{{ $color->id_color }}">{{ $color->color }}</option>'
                        + '@endforeach'
                    +'</select>'
                +'</td>';
            html +='<td><input class="form-control" type="number" min="0" max="0" name="qty[]" value="0" readonly ></td>';
            html +='<td><button type="button" class="btn btn-danger remove"><i class="fas fa-times"></i></button></td>';
            html +='</td>';
            $('tbody').append(html);

            $('.remove').click(function(){
                $(this).closest('tr').remove();
            });
        });

        $('.save').click(function(){

            



                
                
        });
      

        


    </script>
@endsection