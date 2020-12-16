@extends('layouts.theme')
@section('title','Tums -- Trang khách hàng')

@section('css')
	{{-- style cart --}}
	<link href="{{ asset('css/front-end/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
	{{-- breadcrumb  --}}
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<nav aria-label="breadcrumb" >
				  <ol class="breadcrumb" style="background: none;">
				    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Home</a></li> 
				    <li class="breadcrumb-item active">Account</li>
				  </ol>
				</nav>
			</div>
			
		</div>
    </div>
    
    <div class="container">
		<div class="row">
			<div class="col-lg-10">
				<h2>
                    <b>
                        THÔNG TIN TÀI KHOẢN
                    </b>
                </h2>
                <p style="font-size: 15px;font-weight: bold">Xin chào, {{ Auth::user()->full_name }}</p>
                <p style="font-size: 15px;font-weight: bold">Đơn hàng gần nhất:</p>
            </div>
            <div class="col-lg-2">
                <button id="edit" data-toggle="modal" data-target="#update">Cập nhật tài khoản</button>
            </div>
		</div>
	</div>
    <br>
    
	{{-- TABLE CART --}}
	<div class="container cart">
		<div class="row">
			<div class="col-lg-12">
				<table class="table">
					<thead>
						<tr>
							<th>Đơn hàng</th>
                            <th>Ngày</th>
                            <th></th>
                            <th>Sản phẩm</th>
							<th>Số lượng</th>
							<th>Tổng đơn hàng</th>
							<th>Tình trạng</th>

						</tr>
					</thead>
					<tbody>
                        @forelse($bills as $value)
                            <tr>
                                <td>#{{ $value->id_bill }}</td>
                                <td>{{ $value->date }}</td>
                                
                                <td style="width: 5%"><img src="{{ $value->img }}" alt="" style="width: 100%"></td>
                                <td>
                                    <b>{{ $value->name_product }}</b><br>
                                    {{ $sizes->size }}, {{ $colors->color }}
                                </td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ number_format($value->price_total,0,',','.') }} đ</td>
                                <td>
                                    @switch($value->bill_status)
                                        @case(1)
                                            Chờ xác nhận
                                            @break
                                        @case(2)
                                            Đã xác nhận đơn hàng
                                            @break
                                        @case(3)
                                            Giao cho vận chuyển
                                            @break
                                        @case(4)
                                            Đã giao cho khách
                                            @break
                                        @case(5)
                                            Huỷ đơn từ người bán
                                            <p>Lý do: {{ $value->note }}</p>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"> 
                                    Bạn chưa có đơn hàng nào..
                                </td>
                            </tr>
                        @endforelse
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
      
      <!-- Modal -->
      <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cập nhật tài khoản</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('account/update') }}/{{ Auth::user()->id }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row"> 
                        <div class="form-group col-sm-6">
                            <label for="">Họ tên</label>
                            <input id="name" class="form-control" type="text" name="name">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Email</label>
                            <input id="email" class="form-control" type="email" name="email">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Địa chỉ</label>
                            <input id="address" class="form-control" type="text" name="address">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">số điện thoại</label>
                            <input id="phone" class="form-control" type="number" name="phone">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Chọn tỉnh</label>
                            <select name="calc_shipping_provinces" required class="custom-select" id="provincial">
                                <option value="">Tỉnh / Thành phố</option>
                            </select>
                        </div>
                        {{-- Chọn quận huyện --}}
                        <div class="form-group col-lg-6">
                            <label for="">Chọn Quận huyện</label>
                            <select name="calc_shipping_district" required class="custom-select" id="district">
                                <option value="">Quận / Huyện</option>
                            </select>
                        </div>
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
      <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
    @if ($errors->any() || session()->has('success') )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        
        </script>
    @endif 
<script>

    $('#edit').click(function(){
        var id= {{ Auth::user()->id }};
        $.ajax({
            url :'{{ asset("/account/edit") }}/'+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "post",
            dataType: "json",
            success: function(data) {
                console.log(data.user);
                for (var i = 0; i < data.user.length; i++) {
                    $('#name').val(data.user[i].full_name);
                    $('#email').val(data.user[i].email);
                    $('#address').val(data.user[i].address);
                    $('#phone').val(data.user[i].phone  );
                }
            }
        });
    });


    //<![CDATA[
    if (address_2 = localStorage.getItem('address_2_saved')) {
        $('select[name="calc_shipping_district"] option').each(function() {
            if ($(this).text() == address_2) {
            $(this).attr('selected', '')
            }
        })
        $('input.billing_address_2').attr('value', address_2)
    }
    if (district = localStorage.getItem('district')) {
        $('select[name="calc_shipping_district"]').html(district)
        $('select[name="calc_shipping_district"]').on('change', function() {
            var target = $(this).children('option:selected')
            target.attr('selected', '')
            $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
            address_2 = target.text()
            $('input.billing_address_2').attr('value', address_2)
            district = $('select[name="calc_shipping_district"]').html()
            localStorage.setItem('district', district)
            localStorage.setItem('address_2_saved', address_2)
        })
    }
    $('select[name="calc_shipping_provinces"]').each(function() {
        var $this = $(this),
            stc = ''
        c.forEach(function(i, e) {
            e += +1
            stc += '<option value=' + e + '>' + i + '</option>'
            $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
            if (address_1 = localStorage.getItem('address_1_saved')) {
            $('select[name="calc_shipping_provinces"] option').each(function() {
                if ($(this).text() == address_1) {
                $(this).attr('selected', '')
                }
            })
            $('input.billing_address_1').attr('value', address_1)
            }
            $this.on('change', function(i) {
            i = $this.children('option:selected').index() - 1
            var str = '',
                r = $this.val()
            if (r != '') {
                arr[i].forEach(function(el) {
                str += '<option value="' + el + '">' + el + '</option>'
                $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str)
                })
                var address_1 = $this.children('option:selected').text()
                var district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('address_1_saved', address_1)
                localStorage.setItem('district', district)
                $('select[name="calc_shipping_district"]').on('change', function() {
                var target = $(this).children('option:selected')
                target.attr('selected', '')
                $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
                var address_2 = target.text()
                $('input.billing_address_2').attr('value', address_2)
                district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('district', district)
                localStorage.setItem('address_2_saved', address_2)
                })
            } else {
                $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>')
                district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('district', district)
                localStorage.removeItem('address_1_saved', address_1)
            }
            })
        })
    })
//]]></script>
@endsection

