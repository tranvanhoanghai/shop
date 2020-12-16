@extends('layouts.themeAdmin')
@section('title', 'Tums | Nhập hàng')
 
@section('css')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('style')
<style>
    .cart-header{
        background:#0090da ;
        padding: 10px;
    }
    .cart-header input{
        outline: none;
        border: none;
        padding: 10px;
        border-radius: 5px  ;
    }
    nav{
        display: initial;
    }
    .action-toolbar {
        height: 36px;
    }
    .list-search{
        background: white;
        position: absolute;
        width: 100%;
        cursor: pointer;
        z-index: 2;
        box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
    }
    .note{
        position: relative;
        height: auto;
    }
    .note i{
        position: absolute;
        top: 3px;
        left: 0;
        color: #999999;
    }
    .note textarea{
        width: 100%;
        border: none;
        padding: 0px 20px;
        border-bottom: 1px solid #cccccc;	
        outline: none;
        height: 30px;
        max-height: 330px;
    }
    .note textarea:focus{
        border-bottom: 2px solid ;
        border-bottom-color: #56ad51;
    }
    .note textarea::-webkit-scrollbar {
        width: 5px;
    }
    .infNcc{
        display: none;
    }
   
</style>
@endsection
@section('content') 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tạo phiếu nhập</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Nhập hàng</li>
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
                <div class="col-sm-9 pl-0">
                    <div class="cart-header row">
                        <div class="col-6">
                            <form action="{{ asset('dashboard/imports/create') }}" method="post" id="formSearch">
                                @csrf
                                <input type="text" id="search" placeholder="Tìm kiếm sản phẩm" autocomplete="off" style='width:100%' @isset($key) value="{{ $key }}" @endisset>
                            </form>
                            @isset($key) 
                                <div>
                                    <span>Từ khoá cho :
                                        <b>{{ $key }}</b>
                                    </span>
                                    <a href="{{ asset('dashboard/imports/create') }}" style="margin-left: 20px; color: white"><i class="fas fa-times"></i></a>
                                </div>
                            @endisset
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success"  data-toggle="modal" data-target="#addProduct">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
    
                    <div class="cart-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng nhập</th>
                                    <th>Giá nhập</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($carts)
                                    @php
                                        $stt = 1;
                                        $total = 0;
                                        $stock = 0;
                                        $qty = 0;
                                    @endphp
                                    @foreach($carts as $key => $cart)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>
                                                <span>{{ $cart->name }}</span><br>
                                                <b>{{ $cart->options->color }} / {{ $cart->options->size }}</b>
                                            </td>
                                            <td>
                                                <div>
                                                    @php
                                                        $stock = $cart->options->stock;
                                                        $qty = $cart->qty;
                                                    @endphp
    
                                                    <form action="{{ asset('dashboard/imports/update') }}/{{ $key }}" method="post" >
                                                        @csrf
                                                        <input data-id="{{ $key }}" type="number" name="qty" min="1" value="{{ $cart->qty }}" class="text-center item-count">
                                                    </form>
                                                   
                                                </div>
                                            </td>
                                            <td>{{ number_format($cart->price,0,',','.') }} đ</td>
                                            <td>{{ number_format($cart->price*$cart->qty,0,',','.') }} đ</td>
                                            <td><a href='{{ asset('dashboard/imports/delete/') }}/{{ $key }}'><button class='btn btn-danger'><i class='fas fa-trash'></i></button></a></td>
    
                                            @php
                                                $total+=$cart->price*$cart->qty;
                                            @endphp
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
    
                    <div class="splitter-horizontal"></div>
    
                    <div class="cart-item">
                        <div class="action-toolbar">
                            <div class="icon-s-f" id="sorts">
                                <a href="{{ asset('dashboard/imports/create/sort/asc') }}"><i class="fas fa-sort-numeric-up-alt"></i></a>
                                <a href="{{ asset('dashboard/imports/create/sort/desc') }}"><i class="fas fa-sort-numeric-down"></i></a>
                            </div>
                            {{ $product_s_c->links() }}
                        </div>
                    
                        <div class="row">
                            @php
                                $id=1;
                            @endphp
                            @foreach($product_s_c as $key => $product)
                                <div class="col-6 col-sm-4 col-xl-2 cart">
                                    <img src="{{ $product->img }}" alt="Lỗi hình ảnh">
                                    <span class="product-name">{{ $product->name_product }}</span>
                                    <b class="product-price">{{ number_format($product->price1,0,',','.') }} đ</b>
                                    <b style="text-align: center;margin-top: 5px; color: red">{{  $product->color  }} / {{  $product->size  }} / SL : {{ $product->quantity }}</b>
                                    <form action="{{ asset("/dashboard/imports/select") }}/{{ $product->id_product }}" method="post" class="formAdd" id="form{{ $id++ }}">
                                        @csrf
                                        <input type="hidden" value="{{ $product->id_size }}" name="id_size">
                                        <input type="hidden" value="{{ $product->id_color }}" name="id_color">
                                        <input type="hidden" value="{{ $product->size }}" name="size">
                                        <input type="hidden" value="{{ $product->color }}" name="color">
                                        <input type="hidden" value="{{ $product->price0 }}" name="price0">
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 pl-0 pr-2">
                    
                    <div class="card">
                        <div class="card-header p-2">
                            <div class="row">
                                <div class="col-1 border-right">
                                    <i class="fas fa-bars" style="cursor: pointer;" ></i>
                                </div>
                                <div class="col-9 border-right">
                                    <i class="fas fa-expand-arrows-alt" style="color: #0088ff;cursor: pointer;"></i>
                                    <a href="{{ asset('dashboard') }}">
                                        <i class="fas fa-home" style="margin-left: 10px"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
    
                        <div class="card-body">
                            <div class="check-out">
                                <div class="sale-user">
                                    <i class="fas fa-user-circle"></i>
                                    <div class="form-output">
                                        {{ Auth::user()->full_name }}
                                    </div>
                                    <div class="date">
                                        {{ date("d-m-Y H:i:s") }}
                                    </div>
                                </div>
                                <form action="{{ asset('dashboard/imports/import') }}" method="POST">
                                    @csrf
                                    <div class="check-out-content">
                                        <div class="customer-search">
                                            <i class="fas fa-search" style="color: #999999"></i>
                                            
                                            <input type="text" name="search" id="searchNcc" placeholder="Tìm nhà cung cấp" autocomplete="off">
                                            <input type="hidden" name="name" id="idNcc" value="">
    
                                            <div class="list-search">
                                                <table class="table mb-0">
                                                    <tbody id="listSearch"></tbody>
                                                </table>
                                            </div>
    
                                            <div class="infNcc row">
                                                <div class="col-6">
                                                    <p>Email</p>
                                                    <p>Số điện thoại</p>
                                                    <p>Địa chỉ</p>
                                                </div>
                                                <div class="col-6">
                                                    <p id="email"></p>
                                                    <p id="phone"></p>
                                                    <p id="address">Địa chỉ</p>
                                                </div>
                                            </div>
                                        </div>
    
                                            
                                        <button class="btn btn-primary addNcc" type="button" data-toggle="collapse" data-target="#collapseExample">
                                            Thêm mới nhà cung cấp
                                        </button>
                                        <div class="collapse" id="collapseExample">
                                            <div class="wrap-actions">
                                                <div class="form-group">
                                                    <label>Tên nhà cung cấp
                                                        <input type="text" class="form-control" name="fullName" placeholder="Nhập tên" autocomplete="off">
                                                    </label>
                                                    <label>Email
                                                        <input type="email" class="form-control" name="email" placeholder="Nhập email" autocomplete="off">
                                                    </label>
                                                    <label>Số điện thoại 
                                                        <input type="number" class="form-control" name="phone" placeholder="Nhập số điện thoại" autocomplete="off">
                                                    </label>
                                                    <label>Địa chỉ
                                                        <textarea class="form-control" rows="3" name="address"></textarea>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="wraper-payment-content">
    
                                            <div class="payment-component" style="font-size: 17px;">
                                                <div class="payment-component-child ">
                                                    <div class="form-group">
                                                        Tổng tiền hàng
                                                        <span class="sum-count money">{{ Cart::count() }}</span>
                                                        <span class="sum-price money">{{ number_format($total,0,',','.') }} đ</span>
                                                    </div>
    
                                                    <div class="form-group" style="height: 30px; position: relative;">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discount">
                                                            Giảm giá
                                                        </button>
                                                        
                                                        @if(!isset($option))
                                                            <input type="number" name="sale" class="discount text-right money"  value="0" readonly>
                                                        @else
                                                            @isset($option)
                                                                @if($option == 'percent')
                                                                    <input type="text" name="sale" class="discount text-right money" value="{{ $value }} %" readonly>
                                                                @else
                                                                    <input type="text" name="sale" class="discount text-right money" value="{{ $value }} đ" readonly>
                                                                @endif
                                                            @endisset
                                                        @endif
                                                    </div>

                                                    @if($total > 0)
                                                        <div class="form-group" style="height: 30px;">
                                                            Thành tiền
                                                            @if(!isset($option))
                                                                <span class="sum-price total money">{{ number_format($total,0,',','.') }} đ</span>
                                                                <input type="hidden" value="{{ $total }}" id="total" name="total">
                                                            @else
                                                                @isset($option)
                                                                    @if($option == 'percent')
                                                                        <span class="sum-price total money">{{ number_format(($total - ($total*$value/100)) ,0,',','.') }} đ</span>
                                                                        <input type="hidden" value="{{ ($total - ($total*$value/100)) }}" id="total" name="total">
                                                                    @else
                                                                        <span class="sum-price total money">{{ number_format($total - $value,0,',','.') }} đ</span>
                                                                        <input type="hidden" value="{{ $total - $value }}" id="total" name="total">
                                                                    @endif
                                                                @endisset
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div> 
                                            </div>
    
                                        </div>
                                    </div>
                                    <div class="note">
                                        <i class="fas fa-pen"></i>
                                        <textarea placeholder="Ghi chú" name="note"></textarea>
                                    </div>
    
                                    <div class="checkout clear-cart">
                                        <button class="btn-check" type="submit" style="outline: none">NHẬP HÀNG</button>
                                    </div>

                                    <div class="support">
                                        <i class="fas fa-phone"></i>
                                        <i> Hỗ trợ khách hàng 1800 6162 </i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="addProduct" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/imports/addProduct') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#a">Thông tin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#b">Mô tả chi tiết</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#c">Thuộc tính</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="a" role="tabpanel">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Tên sản phẩm
                                            <input class="form-control" type="text" name="createName" value="{{ old('createName') }}" placeholder="Nhập tên sản phẩm" required autocomplete="off">
                                        </label>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="type">Danh mục</label>
                                        <select class="form-control" style="text-transform: uppercase" name="type">
                                            @foreach($categorys as $category)
                                                <option value="{{ $category->id_product_type  }}" >
                                                    {{ $category->name_product_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="type">Đơn vị tính</label>
                                        <select class="form-control" style="text-transform: uppercase" name="unit">
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

                                    <div class="form-group col-6">
                                        <label >Giá nhập
                                            <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price0" min="10000" value="{{ old('price0') }}" required>
                                        </label>
                                    </div>

                                    <div class="form-group col-6">
                                        <label >Giá sản phẩm
                                            <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" name="price1" value="{{ old('price1') }}" required>
                                        </label>
                                    </div>

                                    <div class="form-group col-6">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" style="cursor: pointer;">
                                            <button class="btn btn-info">
                                                Thêm ảnh sản phẩm
                                            </button>
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                                    </div>

                                    <div class="form-group col-12">
                                        <div class="col-sm-12 col-12" id="holder">
                                            <img>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="b" role="tabpanel">
                                <div class="form-group">
                                    <label for="editor1">Mô tả</label>
                                    <textarea class="form-control ckeditor" rows="3" name="createDescription" style="height: 600px"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="c" role="tabpanel">
                                
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
                                            <tbody id="content">
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
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
    {{-- MODAL DISCOUNT --}}
    <div class="modal" id="discount">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/imports/create/discount') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="option-sale" >
                            <div class="form-group">
                                <select class="form-control mb-3" name="option">
                                    <option value="percent">Giảm theo phần trăm</option>
                                    <option value="thousand">Giảm theo giá tiền</option>
                                </select>

                                <input id="value" name="value" class="w-100" type="number" min="0" required placeholder="Nhập giá trị giảm">
                              </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 

@section('js')
    @if ($errors->any() || session()->has('success'))
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        </script>
    @endif

    <script src="{{ asset('vendor/laravel-filemanager//js/stand-alone-button.js') }}"></script>
    <script>
        $('.d ').addClass('menu-open');
        $('.d > .nav-link').addClass('active');
        $('.d .nav-treeview #imports').addClass('active');

        $('#search').keyup(function(){
            var key =  $('#search').val();
            $('#formSearch').attr('action', '{{ asset("/dashboard/imports/create/search") }}=' +key);
        });

        var route_prefix = "{{ asset('laravel-filemanager') }}";
        $('#lfm').filemanager('image', {prefix: route_prefix});

        $(".cart").each(function(index) {
            index++;
            $(this).on("click", function(){
                $('#form'+index+'').submit()
            });
        });

        $(".item-count").each(function(index) {
            $(this).click(function(){
                $(this).select();
            });

            $(this).keyup(function(){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '8' || keycode == '32'){
                    return false; 
                }
                $(this).parents("form").submit();
            })
        });

        $('#cus_pay').keyup(function(){
            var cus_pay = Number($('#cus_pay').val());
            var total = Number($('#total').val());

            if(cus_pay >= total){
                $('.btn-check').prop("disabled", false);
            }
            $('.refunds-custommer').text(cus_pay-total);
        });

        $('#searchNcc').keyup(function(){
            var key = $('#searchNcc').val();
            if(key ==''){
                $('.list-search').css("display","none");
                $('.addNcc').css("display","block");
                $('.infNcc').css("display","none");
            }else{
                $('.list-search').css("display","block");
            }

            $.ajax({
                url:'{{ asset("/dashboard/imports/suggestions") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                data: {
                    key:key
                },
                success: function(data) {
                    console.log(data);
                    var content = "";
                    if(data.user.length == 0){
                            content += "<tr><td style='display:none'>" +
                            + data.user.length 
                            + "</td><td>" 
                            + "Không có kết quả phù hợp"
                            + "</td></tr>";
                    }
                    for (var i = 0; i < data.user.length; i++) {
                        
                            content += "<tr><td style='display:none'>" +
                            + data.user[i].id  
                            + "</td><td data-id='"+data.user[i].id+"' data-name='"+data.user[i].full_name+"' data-email='"+data.user[i].email+"'data-phone='"+data.user[i].phone+"'data-address='"+data.user[i].address+"'>" 
                            + "<span style='color:blue'>"+data.user[i].full_name +"</span>" +"<br>"
                            + "<span style='color:red'>"+data.user[i].phone +"</span>"
                            + "</td></tr>";
                        
                    }
                    $('#listSearch').html(content);
                    $('#listSearch td').click(function(){
                        
                        $('#idNcc').val($(this).data('id'));
                        $('#searchNcc').val($(this).data('name'));

                        $('.infNcc').css("display","flex");
                        $('#email').text($(this).data('email'));
                        $('#phone').text($(this).data('phone'));
                        $('#address').text($(this).data('address'));

                        $('.list-search').css("display","none");
                        $('.addNcc').css("display","none");
                    });
                }
            }); 
        });

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
            $('#content').append(html);

            $('.remove').click(function(){
                $(this).closest('tr').remove();
            });
        });
        
    </script>
@endsection
