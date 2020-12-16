@extends('layouts.theme')
@section('title','checkout') 

@section('css')
	{{-- style cart --}}
	<link href="{{ asset('css/front-end/checkout.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.1/dist/bootstrap-float-label.min.css">

@endsection

{{-- MAIN --}}
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<nav aria-label="breadcrumb">
				<ol class="breadcrumb" style="background: none;">
					<li class="breadcrumb-item"><a href="{{ asset('/') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ asset('/cart') }}">Cart</a></li>
					<li class="breadcrumb-item active">Checkout</li>
				</ol>
				</nav>
			</div>
		</div>
	</div>
	<div class="container checkout">
		<div class="row">
			<div class="col-sm-6 info">
				<form action="{{ asset('checkout') }}" method="post" >
					@csrf
					<h4>Thông tin thanh toán</h3>
						<br> 
					@guest
						<p>Bạn đã có tài khoản?
							<a href="{{ route('login') }}" title="">
								Đăng nhập
							</a>
						</p>
						{{-- Họ tên  --}}
						<div class="form-group">
							<span class="has-float-label">
								<input class="form-control" id="name" type="text" placeholder="Họ và tên" required "/>
								<label for="name">Họ và tên</label>
							</span>
						</div>

						{{-- email --}}
						<div class="form-row">
							<div class="form-group col-lg-8">
								<span class="has-float-label">
									<input class="form-control" id="email" type="email" placeholder="Email" required "/>
									<label for="email">Email</label>
								</span>
							</div>
							{{-- số điện thoại --}}
							<div class="form-group col-lg-4">
								<span class="has-float-label">
									<input class="form-control" id="phone" type="number" placeholder="Số điện thoại" required "/>
									<label for="phone">Số điện thoại</label>
								</span>
							</div>
						</div>
						{{-- địa chỉ --}}
						<div class="form-group">
							<span class="has-float-label">
								<input class="form-control" id="address" type="text" placeholder="Địa chỉ" required" />
								<label for="address">Địa chỉ</label>
							</span>
						</div>
					@else
						{{-- Họ tên  --}}
						<div class="form-group">
							<span class="has-float-label">
								<input class="form-control" id="name" name="name" type="text" placeholder="Họ và tên" required  value="{{ Auth::user()->full_name }} "/>
								<label for="name">Họ và tên</label>
							</span>
						</div>

						{{-- email --}}
						<div class="form-row">
							<div class="form-group col-lg-8">
								<span class="has-float-label">
									<input class="form-control" id="email" name="email" type="email" placeholder="Email" readonly value="{{ Auth::user()->email }}"/>
									<label for="email">Email</label>
								</span>
							</div>
							{{-- số điện thoại --}}
							<div class="form-group col-lg-4">
								<span class="has-float-label">
									<input class="form-control" id="phone"name="phone"  type="number" placeholder="Số điện thoại" required value="{{ Auth::user()->phone }}"/>
									<label for="phone">Số điện thoại</label>
								</span>
							</div>
						</div>
						{{-- địa chỉ --}}
						<div class="form-group">
							<span class="has-float-label">
								<input class="form-control" id="address" name="address" type="text" placeholder="Địa chỉ" required value="{{ Auth::user()->address }}"/>
								<label for="address">Địa chỉ</label>
							</span>
						</div>
					@endguest

					{{-- Chọn tỉnh thành --}}
					<div class="form-row">
						<div class="form-group col-lg-8">
							<select name="calc_shipping_provinces" required="" class="custom-select">
								<option value="">Tỉnh / Thành phố</option>
							</select>
						</div>
						{{-- Chọn quận huyện --}}
						<div class="form-group col-lg-4">
							<select name="calc_shipping_district" required="" class="custom-select">
								<option value="">Quận / Huyện</option>
							</select>
						</div>
					</div>
					<br><br>

					<h4 style="margin-bottom: 20px;">Vận chuyển</h3>

					<div class="form-group">
						<div class="radio-wrapper">
							<label class="radio-label" for="shipping_rate_id_85211">
								<div class="radio-input">
									<input id="shipping_rate_id_85211" class="input-radio" type="radio" name="shipping_rate_id" value="30000" checked="">
								</div>
								<span class="radio-label-primary">Giao hàng tận nơi</span>
								<span class="radio-accessory content-box-emphasis">
									30 000 ₫
								</span>
							</label>
						</div>
					</div>
<br>
					<h4 style="margin-bottom: 20px;"> Thanh toán</h3>
					<div class="form-group">
						<div class="content-box" style="border: 1px solid #ddd">
							<div class="radio-wrapper content-box-row">
								<label class="radio-label" for="payment_method_id_98864">
									<div class="radio-input">
										<input id="payment_method_id_98864" class="input-radio" name="payment_method_id" type="radio" value="Thanh toán khi giao hàng (COD)" checked="checked">
									</div>
									<span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
								</label>
							</div>
							<div style="padding: 1.3em;background: #f8f8f8">
								Bạn chỉ phải thanh toán khi nhận được hàng
							</div>
						</div>
					</div>
<br>
					<div class="form-group">
						<span class="has-float-label">
							<textarea class="form-control" id="note" rows="3" name='note'></textarea>
							<label for="note">Ghi chú</label>
						</span>
					</div>
			</div>
			<div class="col-lg-6 error">
				Thông báo
				Một số sản phẩm trong giỏ hàng không còn đủ số lượng để đặt hàng. Chúng tôi xin lỗi vì sự bất tiện này.
				<a href="{{ asset('cart') }}">Quay lại giỏ hàng</a>
			</div>

			<div class="col-lg-6" style="border-left: 1px solid #eee;margin-bottom: 100px;" >
				<table class="table product-table">
					<thead>
						<tr>
							<th colspan="2">Sản phẩm</th>
							<th>Số lượng</th>
							<th>Tổng</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$total_price = 0;	
							$qty=0;
							$stock=0;
						?>
						@foreach($items as $key => $item)
							<tr>
								<td style="width: 10%" id="pro">
									<img style="width: 100%" src="{{ $item->options->img }}" alt="">
								</td>

								<td id="name">
									<p>{{ $item->name }}</p>
									@foreach($sizes as $key => $size)
										@if($item->options->size == $size->id_size)
											<span>{{ $size->size }} </span>,
										@endif
									@endforeach
										
									@foreach($colors as $key => $color)
										@if($item->options->color == $color->id_color)
											<span>{{ $color->color }} </span>
										@endif
									@endforeach
								</td>
								<td>
									@foreach($p_s_c as $key => $p)
										@if($item->options->color == $p->id_color && $item->options->size == $p->id_size  && $item->id == $p->id_product)
											@php
												$qty = $item->qty;
												$stock = $p->quantity;
											@endphp
											{{ $item->qty }}
										@endif
									@endforeach
								</td>
								<td>
									<?php
										$total_price += $item->price*$item->qty;
									?>
									{{ number_format($item->price*$item->qty,0,',','.')  }} đ
								</td>
							</tr>
							@endforeach
					</tbody>
				</table>
<hr>
				<table class="table">
					<thead style="display: none;">
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr style="border-bottom: 1px solid #ddd;">
							<td colspan="3" >
								<input type="text" id="coupon" placeholder="Mã giảm giá" style="width: 100%;padding: 10px;" autocomplete="off" @isset($coupons)value="{{ $coupons->coupon_code }}"@endisset>
							</td>
							<td colspan="1" style="text-align: right">
								<button type="button" id="checkCoupon" disabled>Sử dụng</button>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								Tạm tính
							</td>
							<td colspan="2" style="text-align: right">
								{{ number_format($total_price,0,',','.') }} đ
							</td>
						</tr>

						<tr style="border-bottom: 1px solid #ddd">
							<td colspan="2">
								Phí ship
							</td>
							<td colspan="2" style="text-align: right">
								{{ number_format(30000 ,0,',','.')  }} đ
							</td>
						</tr>
						@isset($coupons)
							<tr style="border-bottom: 1px solid #ddd">
								<td colspan="2">
									Giảm giá
								</td>
								@if($coupons->coupon_status == 0)
									<td colspan="2" style="text-align: right">
										{{ $coupons->coupon_value }} %
									</td>
								@else
									<td colspan="2" style="text-align: right">
										{{ number_format($coupons->coupon_value ,0,',','.')  }} đ
									</td>
								@endif
								
							</tr>
						@endisset 
						<tr>
							<td colspan="2">
								<h3>Tổng tiền</h4>
							</td>

							<td colspan="2" style="text-align: right">
								@if(!isset($coupons))
									<h2>{{ number_format($total_price + 30000,0,',','.') }} đ</h2>
									<input type="hidden" name="total"  value="{{ $total_price + 30000 }}">

								@else
									@isset($coupons)
										@if($coupons->coupon_status == 0)
											<h2>{{ number_format( ($total_price + 30000) - (($total_price + 30000)*$coupons->coupon_value)/100, 0,',','.') }} đ</h2>
										@else
											<h2>{{ number_format( $total_price + 30000 - $coupons->coupon_value, 0,',','.') }} đ</h2>
										@endif
									@endisset
								@endif

								@isset($coupons)
									@if($coupons->coupon_status == 0)
										<input type="hidden" name="total"  value="{{ ($total_price + 30000) - (($total_price + 30000)*$coupons->coupon_value)/100 }}">
										<input type="hidden" name="coupon"  value="{{ $coupons->coupon_value }} %">
									@else
										<input type="hidden" name="total"  value="{{ $total_price + 30000 - $coupons->coupon_value }}">
										<input type="hidden" name="coupon"  value="{{ $coupons->coupon_value }} đ">
									@endif
									<input type="hidden" name="id_coupon"  value="{{ $coupons->coupon_id }}">
								@endisset
							</td>
						</tr>
					</tbody>
				</table>
				@if($qty <= $stock)
					<button class="check" type="submit" style="float: right;margin-top: 20px;">Đặt hàng</button>	
				@endif
			</form>
			</div>
		</div>
	</div>

	<form action="{{ asset('checkout/coupon') }}" method="post" id="formCoupon">
		@csrf
		<input type="hidden" id="getCoupon" name="coupon">
	</form>

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

     @if ($errors->any() || session()->has('success') )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        
        </script>
	@endif
	
	@if($qty > $stock)
		<script>
			$('.info').hide();
			$('.error').show();
		</script>
		@else	
		<script>
			$('.info').show();
			$('.error').hide();
		</script>			
	@endif
	<script>
		// check nếu chưa có sp thì disable btn
		var check = document.getElementById('pro');
		if (check === null) {
			$('.check').attr('disabled', 'disabled');
		};

		$('#coupon').keyup(function(){ 
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '32'){
				return false; 
			}else if( $('#coupon').val() != ''){
				$('#checkCoupon').prop("disabled", false);
			}else{
				$('#checkCoupon').attr('disabled', 'disabled');
			}
		});
		$('#checkCoupon').click(function(){
			var coupon = $('#coupon').val();
			$('#getCoupon').val(coupon);
			$("#formCoupon").submit();
		});
		
	</script>
	<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
	<script> 
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
		c.forEach(function(i) {
		// e += +1
			stc += '<option value="' + i + '">' + i + '</option>'
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
	</script>
@endsection


