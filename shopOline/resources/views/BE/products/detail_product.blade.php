@extends('layouts.themeAdmin')
@section('title',  "Tums | $slug")

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
            <div class="row">
                <div class="col-md-12">
                    <h6>
                        <a href="{{ asset('dashboard/products/') }}" class="">
                            <i class="fas fa-chevron-left"></i>    
                            Quay lại danh sách sản phẩm
                        </a>
                    </h6>
                    <span style="font-weight: 500;font-size: 30px">
                        {{ $products->name_product }}
                    </span>
                    <br>
                    <span>
                        @if($products->status == 'true')
                            <a href="{{ asset('shop') }}/{{ $products->slug_product }}" target="target">
                                Xem trên web
                            </a>
                        @endif
                    </span>
                    <br>
                    <br>
                    @isset($stocks)
                        @if($stocks->stock == 0)
                            <button type="button" class="btn btn-danger">
                                Hết hàng
                            </button>
                        @endif
                    @endisset
                </div>
                <!-- /.col-md-12 -->
            </div><br>
            <!-- /.row -->
            <form action="{{ asset('dashboard/products/update') }}/{{ $products->id_product }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="ss1">
                            <label>Tên sản phẩm
                                <input type="text" name="nameProduct" value="{{ $products->name_product }}" required>
                            </label>
                            <div class="form-group">
                                <label for="editor1">Mô tả</label>
                                <textarea class="form-control ckeditor" rows="3" name="editor">{{ $products->description  }}</textarea>
                                
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
                                
                                <div class="col-md-12" id="holder">
                                    <img  style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>

                            <div class="row" style="margin-top: 20px">
                                @foreach($images as $key => $image)
                                    @if($products->id_product == $image->id_product)
                                        <div class="col-sm-2 col-4  image" style="position: relative; overflow: hidden; margin-bottom: 10px">
                                            <img src="{{ $image->image }}" alt="{{ $image->image }}" style="width: 100%">
                                            <div class="mask">
                                                <ul class="action">
                                                    <li>
                                                        <a href="{{ $image->image }}">
                                                            <i class="fas fa-eye" style="color: white"></i>
                                                        </a>

                                                        <a href="{{ asset('dashboard/products/delete/img') }}/{{ $image->id }}">
                                                            <i class="fas fa-trash" style="color: white"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="ss1 ss1-price" style="margin-top: 20px">
                            <div class="">
                                <h5 style="font-weight: 600">Giá sản phẩm</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label >Giá vốn
                                        <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" value="{{ number_format($products->price0,0, ',','.') }}" name="price0" min="10,000">
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label >Giá sản phẩm
                                        <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" value="{{ number_format($products->price1,0, ',','.') }}" name="price1" min="10,000">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="ss1-property ss1">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5 style="font-weight: 600">Thuộc tính</h5>
                                </div>
        
                                <div class="col-md-5 text-right">
                                    <a href="#" data-toggle="modal" data-target="#property" >
                                        Thêm thuộc tính
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead >
                                            <tr>
                                                <th>Size</th>
                                                <th>Màu sắc</th>
                                                <th>Số lượng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ( $product_size_colors as $value)
                                                <tr>
                                                    <td style="width: 30%">
                                                        {{ $value->size }}
                                                    </td>
                                                    <td style="width: 30%">
                                                        {{ $value->color }}
                                                    </td>
                                                    <td style="width: ">
                                                        {{ $value->quantity }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary edit" type="button" data-toggle="modal" data-target="#upproperty" data-qty="{{ $value->quantity }}" data-size="{{ $value->id_size }}"  data-color="{{ $value->id_color }}" data-idp="{{ $products->id_product }}"  >
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <button class="btn btn-danger delete" type="button" data-toggle="modal" data-target="#delete"  data-size="{{ $value->id_size }}"  data-color="{{ $value->id_color }}" data-idp="{{ $products->id_product }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="ss1 ss2-status">
                            <div class="">
                                <h5 style="font-weight: 600">Trạng thái</h5>
                            </div>
                            <div>

                                @if($products->status == 'true')
                                    <label for=""> 
                                        <input type="radio" name="status" id="" checked value="true">
                                        Hiển thị
                                    </label>
                                @else
                                    <label for=""> 
                                        <input type="radio" name="status" id="" value="true">
                                        Hiển thị
                                    </label>
                                @endif

                                @if($products->status == 'false')
                                    <label for=""> 
                                        <input type="radio" name="status" id="" value="false" checked>
                                        Ẩn
                                    </label>
                                @else
                                    <label for=""> 
                                        <input type="radio" name="status" id="" value="false">
                                        Ẩn
                                    </label>
                                @endif
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
                                        @if($products->id_product_type == $category->id_product_type )
                                            <option value="{{ $category->id_product_type  }}" selected>
                                                {{ $category->name_product_type }}
                                            </option>
                                        @else
                                            <option value="{{ $category->id_product_type  }}" >
                                                {{ $category->name_product_type }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
<br>
                                <div class="form-group">
                                    <label for="type">Đơn vị tính</label>
                                    <p class="unit d-none">{{ $products->unit }}</p>
                                    <select class="form-control" id="unit" style="text-transform: uppercase" name="unit">
                                        <option value="Cái">Cái</option>
                                        <option value="Bộ">Bộ</option>
                                        <option value="Đôi">Đôi</option>
                                    </select>
                                  </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 50px;border-top: 1px solid #bbb; padding: 20px 0">
                    
                    <div class="col-6 mr-auto">
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteProduct">
                            Xoá sản phẩm
                        </button>
                    </div>

                    <div class="col-6 ml-auto" style="text-align: right">
                        <button class="btn btn-primary" type="submit">
                            Lưu
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- Modal ADD SIZE COLOR QTY -->
    <div class="modal" id="property" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm thuộc tính</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ asset('dashboard/products/add/property') }}/{{ $products->id_product }}" method="post">
                @csrf
                <div class="modal-body">
                    <table class="table">
                        <thead >
                            <tr>
                                <th>Size</th>
                                <th>Màu sắc</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="size" id="size" style="color: black" required>
                                        @foreach($sizes as $key => $size)
                                            <option value="{{ $size->id_size }}">{{ $size->size }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="color" id="color" style="color: black" required>
                                        @foreach($colors as $key => $color)
                                            <option value="{{ $color->id_color }}">{{ $color->color }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="addQty" required min="1" max="100">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Modal UPDATE QUANTITY -->
    <div class="modal" id="upproperty" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Sửa số lượng</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('dashboard/products/update/property') }} }}" method="POST" id="updateQty">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số lượng</label>
                        <input type="number" class="form-control" name="upQty" id="upQty" required min="0" max="500">
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <!-- Modal DELETE SIZE COLOR QTY -->
    <div class="modal" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xoá thuộc tính</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="formdelete">
                    @csrf
                    <div class="modal-body">
                    Bạn có muốn xoá thuộc tính của sản phẩm
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger">Xoá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DELETE PRODUCT --}}
    <div class="modal" id="deleteProduct" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xoá {{ $products->name_product }} ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/products/delete') }}/{{ $products->id_product }}" method="post" id="formdelete">
                    @csrf
                    <div class="modal-body">
                        Bạn có chắc muốn xóa sản phẩm <b>{{ $products->name_product }}</b> Hành động này không thể khôi phục.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-danger">Xoá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL ERRORS --}}
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
    </div>

@endsection 

@section('js')
    @if ($errors->any() )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        </script>
    @endif 
    <script src="{{ asset('vendor/laravel-filemanager//js/stand-alone-button.js') }}"></script>
    <script>

        $('.c ').addClass('menu-open');
        $('.c > .nav-link').addClass('active');
        $('.c .nav-treeview #products').addClass('active');

        var route_prefix = "{{ asset('laravel-filemanager') }}";
        $('#lfm').filemanager('image', {prefix: route_prefix});
        
        $('.edit').click(function(){
            var id_p = $(this).data('idp');
            var id_s = $(this).data('size');
            var id_c = $(this).data('color');

            $('#upQty').val($(this).data('qty'));
            $('#updateQty').attr('action', '{{ asset("dashboard/products/update/property") }}/'+ id_p +'/'+ id_s +'/'+ id_c)
        });

        $('.delete').click(function(){
            var id_p = $(this).data('idp');
            var id_s = $(this).data('size');
            var id_c = $(this).data('color');
            $('#formdelete').attr('action', '{{ asset("dashboard/products/delete/property") }}/'+ id_p +'/'+ id_s +'/'+ id_c)
        });

        var b = $('.unit').text();
        $('#unit').find('option').each(function(i,e){
            if($(e).text() == b){
                $('#unit').prop('selectedIndex',i);
            }
        });



        
    // CKEDITOR.replace('editor', {
        //     language:'vi',
        //     filebrowserImageBrowseUrl:'{{ asset('laravel-filemanager?type=Images') }}',
        //     filebrowserImageUploadUrl: '{{ asset('laravel-filemanager/upload?type=Images&_token=') }}',
        //     filebrowserBrowseUrl: '{{ asset('laravel-filemanager?type=Files') }}',
        //     filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        // });
    </script>
@endsection
