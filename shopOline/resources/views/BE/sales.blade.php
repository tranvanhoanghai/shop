<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tums | Bán hàng</title>
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

</head>
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
        z-index: 10;
        box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
    }
    .option-sale{
        padding: 5px;
    }
    .option-sale input{
        outline: none;
        background: none;
        border: 1px solid #bbb;
        padding: 5px;
    }
   
</style>
<body>
    <div class="container-fluid example-screen">
        <div class="row">
            <div class="col-sm-9 pl-0">
                <div class="cart-header">
                    <div class=" row">
                        <div class="col-6">
                            <form action="{{ asset('dashboard/sales/') }}" method="post" id="formSearch">
                                @csrf
                                <input type="text" id="search" placeholder="Tìm kiếm sản phẩm" autocomplete="off" style='width:100%' @isset($key) value="{{ $key }}" @endisset>
                            </form>
                            @isset($key) 
                                <div>
                                    <span>Từ khoá cho :
                                        <b>{{ $key }}</b>
                                    </span>
                                    <a href="{{ asset('dashboard/sales') }}" style="margin-left: 20px; color: white"><i class="fas fa-times"></i></a>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="cart-list">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
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

                                                <form action="{{ asset('dashboard/sales/update') }}/{{ $key }}" method="post">
                                                    @csrf
                                                    <input type="number" name="qty" min="1" max="{{ $cart->options->stock }}"value="{{ $cart->qty }}" class="text-center item-count" onClick="this.select();">
                                                </form>
                                               
                                            </div>

                                            @if($qty > $stock)
                                                <span style="font-size: 15px; color:red">Còn {{ $cart->options->stock }} sản phẩm</span>
                                            @endif

                                        </td>
                                        <td>{{ number_format($cart->price,0,',','.') }} đ</td>
                                        <td>{{ number_format($cart->price*$cart->qty,0,',','.') }} đ</td>
                                        <td><a href='{{ asset('dashboard/sales/delete/') }}/{{ $key }}'><button class='btn btn-danger'><i class='fas fa-trash'></i></button></a></td>
                                        @php
                                            $total += $cart->price*$cart->qty;
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
                            <a href="{{ asset('dashboard/sales/sort/asc') }}"><i class="fas fa-sort-numeric-up-alt"></i></a>
                            <a href="{{ asset('dashboard/sales/sort/desc') }}"><i class="fas fa-sort-numeric-down"></i></a>
                        </div>
                        {{ $product_s_c->links() }}
                    </div>
                
                    <div class="row">
                        @php
                            $id=1;
                        @endphp
                        @foreach($product_s_c as $key => $product)
                            <div class="col-6 col-sm-4 col-xl-2 cart mb-3" style="overflow: auto">
                                <img src="{{ $product->img }}" alt="Lỗi hình ảnh">
                                <span class="product-name">{{ $product->name_product }}</span>
                                <b class="product-price">{{ number_format($product->price1,0,',','.') }} đ</b>
                                <b style="text-align: center;margin-top: 5px; color: red">{{  $product->color  }} / {{  $product->size  }} / SL : {{ $product->quantity }}</b>
                                <form action="{{ asset("/dashboard/sales/add") }}/{{ $product->id_product }}" method="post" class="formAdd" id="form{{ $id++ }}">
                                    @csrf
                                    <input type="hidden" value="{{ $product->id_size }}" name="id_size">
                                    <input type="hidden" value="{{ $product->id_color }}" name="id_color">
                                    <input type="hidden" value="{{ $product->size }}" name="size">
                                    <input type="hidden" value="{{ $product->color }}" name="color">
                                    <input type="hidden" value="{{ $product->quantity }}" name="stock">
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 pl-0 pr-2">
                <form action="{{ asset('dashboard/sales/checkout') }}" method="post">
                    @csrf
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
                                <div class="check-out-content">
                                    <div class="customer-search">
                                        <i class="fas fa-search" style="color: #999999"></i>
                                        
                                        <input type="text" name="search" id="searchCus" placeholder="Tìm khách hàng" autocomplete="off">
                                        <input type="hidden" name="name" id="idCus" value="">

                                        <div class="list-search">
                                            <table class="table mb-0" >
                                                <tbody id="listSearch"></tbody>
                                            </table>
                                        </div>
                                        <div class="add-customer">
                                            <i class="fas fa-plus" data-toggle="modal" data-target="#"><div class="tron"></div></i>
                                        </div>
                                    </div>
                                    <div class="wraper-payment-content">
                                        <div class="btn-label">
                                            <div class="hoadon">
                                                Hoá đơn
                                            </div>
                                        </div>

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

                                                <div class="form-group">
                                                    <b>Khách cần trả</b>

                                                    @if(!isset($option))
                                                        <span class="customer-need-pay money">{{ number_format($total,0,',','.') }} đ</span>
                                                        <input type="hidden" name="total" id="total" value="{{ $total }}">
                                                    @else
                                                        @isset($option)
                                                            @if($option == 'percent')
                                                                <span class="customer-need-pay money">{{ number_format($total- ($total*$value/100),0,',','.') }} đ</span>
                                                                <input type="hidden" name="total" id="total" value="{{ $total - ($total*$value/100) }}">
                                                                <input type="hidden" name="sale" value="{{ $value }} %">
                                                            @else
                                                                <span class="customer-need-pay money">{{ number_format($total-$value,0,',','.') }} đ</span>
                                                                <input type="hidden" name="total" id="total" value="{{ $total-$value }}">
                                                                <input type="hidden" name="sale" value="{{ $value }} đ">
                                                            @endif
                                                        @endisset
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    Khách thanh toán
                                                    @if(!isset($option))
                                                        <input id="cus_pay" type="number" name="cus_pay" class="customer-pay text-right money" value="{{ $total }}" required onClick="this.select()">
                                                    @else
                                                        @isset($option)
                                                            @if($option == 'percent')
                                                                <input id="cus_pay" type="number" name="cus_pay" class="customer-pay  text-right money" value="{{ $total - ($total*$value/100) }}" required onClick="this.select();">
                                                            @else
                                                                <input id="cus_pay" type="number" name="cus_pay" class="customer-pay  text-right money" value="{{ $total-$value }}" required onClick="this.select();">
                                                            @endif
                                                        @endisset
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    Tiền thừa trả khách
                                                    <span class="refunds-custommer money">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="note">
                                    <i class="fas fa-pen"></i>
                                    <textarea placeholder="Ghi chú" type="" name="note"></textarea>
                                </div>
                                @if( $qty < $stock || $stock !=0)
                                    <div class="checkout clear-cart" onclick="window.print()">
                                        <button class="btn-check" type="submit" style="outline: none">THANH TOÁN</button>
                                    </div>
                                @endif
                                    <div class="support">
                                    <i class="fas fa-phone"></i>
                                    <i> Hỗ trợ khách hàng 1800 6162 </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <div class="example-print">
        <div class=" row">
            <div class="col-12 text-center">
                <b style="font-size: 40px">
                    Hoá đơn bán lẻ
                </b><br>
                <b>Tummachines</b><br>
                <b>tummachines@gmail.com</b><br>
                <p>{{ date("Y-m-d") }}</p>
            </div>
            <div class="col-6 text-left">
                <b>Khách hàng: </b> <span id="getCus"></span><br>
                
            </div>
        </div><br>
        <div class="table">
            <table class="table content-print">
                <thead>
                    <tr>
                        <th class="text-center">Tên sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $value)
                        <tr>
                            <td style="width: 55%">

                                <span>{{ $cart->name }}</span><br>
                                <b>{{ $cart->options->color }} / {{ $cart->options->size }}</b>
                            </td>
                            <td style="width: 15%" class="text-center">
                                {{ $value->qty }}
                            </td>
                            <td class="text-right" style="width:15%">
                                {{ number_format($value->price, 0, ',', '.') }} đ
                            </td>
                            <td class="text-right" style="width: 15%">
                                {{ number_format($value->price*$value->qty , 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table text-right print">
                <tr class=" border-0">
                    <td></td>
                    <td></td>
                    <td colspan="4">Chiết khấu</td>
                    <td>
                        <span id="getSale"></span>
                    </td>

                </tr>
                <tr class=" border-0">
                    <td></td>
                    <td></td>
                    <td colspan="4">Giá sau chiết khấu</td>
                    <td>
                        <span id="getTotal"></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4">
                        <b>Tổng tiền </b>
                    </td>
                    <td>
                        <b id="Total"></b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
  
    <div class="modal" id="discount">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset('dashboard/sales/discount') }}" method="post">
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
    <p id="app"></p>

    <script src="{{asset('js/jquery-3.4.1.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- AdminLTE -->
    <script>
        $(document).ready(function(){

            $(".cart").each(function(index) {
                index++;
                $(this).on("click", function(){
                    $('#form'+index+'').submit()
                });
            });

            $('#search').keyup(function(){
                var key =  $('#search').val();
                $('#formSearch').attr('action', '{{ asset("/dashboard/sales/search") }}=' +key);
            });
            

            $('#cus_pay').keyup(function(){
                var cus_pay = Number($('#cus_pay').val());
                var total = Number($('#total').val());

                if(cus_pay >= total){
                    $('.btn-check').prop("disabled", false);
                }
                $('.refunds-custommer').text(cus_pay-total);
            });

            $('#getSale').text($('.discount').val());
            $('#getTotal').text($('.customer-need-pay').text());
            $('#Total').text($('.customer-need-pay').text());

            $('#searchCus').keyup(function(){
                var key = $('#searchCus').val();
                if(key ==''){
                    $('.list-search').css("display","none");
                }else{
                    $('.list-search').css("display","block");
                }

                $.ajax({
                    url:'{{ asset("/dashboard/sales/suggestions") }}', 
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
                                + "</td><td data-id='"+data.user[i].id+"' data-name='"+data.user[i].full_name+"'>" 
                                + "<span style='color:blue'>"+data.user[i].full_name +"</span>" +"<br>"
                                + "<span style='color:red'>"+data.user[i].phone +"</span>"
                                + "</td></tr>";
                            
                        }
                        $('#listSearch').html(content);
                        $('#listSearch td').click(function(){
                            var id = $(this).data('id');
                            var name = $(this).data('name');
                            $('#idCus').val(id);
                            $('#searchCus').val(name);
                            $('.list-search').css("display","none");
                            $('#getCus').text($('#searchCus').val());
                        });
                    }
                 }); 
            });

 
        });
    </script>
</body>
</html>