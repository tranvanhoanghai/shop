@extends('layouts.theme')
@section('title','cart')

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
				    <li class="breadcrumb-item active">Cart</li>
				  </ol>
				</nav>
			</div>
			
		</div>
	</div>

	{{-- TABLE CART --}}

	<div class="container cart">
		<div class="row">
			<div class="col-lg-12">
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
						@php
							$total_price = 0;
							$stock = 0;
							$qty = 0;
						@endphp

						{{-- @guest  --}}
							@forelse($items as $key => $item)
								<tr>
									<td style="width: 10%">
										<a href="{{ asset('shop') }}/{{ $item->options->slug }}">
											<img style="width: 100%" src="{{ $item->options->img }}" alt="">
										</a>
									</td>

									<td>
										<a href="{{ asset('shop') }}/{{ $item->options->slug }}" style="color: black">
											<p>{{ $item->name }}</p>
										</a>
										
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
										<div>
											<form action="{{ asset('cart/update') }}" method="POST">
												@csrf
												@foreach($p_s_c as $key => $p)
													@if($item->options->color == $p->id_color && $item->options->size == $p->id_size  && $item->id == $p->id_product)
														@php
															$qty = $item->qty;
															$stock = $p->quantity;
														@endphp
														<input class="input-number" type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $p->quantity}}">
													@endif
												@endforeach

												<input type="hidden" name="rowId" value="{{ $item->rowId }}">
												<button type="submit" style="margin-top: 0">Cập nhật</button>
											</form> 
												
										</div>
										@if($qty > $stock)
											<span style="color: red">còn {{ $stock  }} sản phẩm</span>
										@else
											<span style="color: #bbb">còn {{ $stock  }} sản phẩm</span>
										@endif

									</td>
									<td>
										{{ number_format($item->price,0,',','.')}} đ
									</td>
									<td>
										{{ number_format($item->price*$item->qty,0,',','.')  }} đ
									</td>
									@php
										$total_price += $item->price*$item->qty;
									@endphp
									<td>
										<a style="color: white" href="{{ asset('/cart/delete') }}/{{ $item->rowId }}">
											<button class="btn btn-danger">
												<i class="fas fa-trash"></i>
											</button>
										</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6">
										<b>
											GIỎ HÀNG CỦA BẠN ĐANG TRỐNG
										</b>
										<br>
										<a href="{{ asset('shop') }}">
											<button>
												MUA HÀNG
											</button>
										</a>
									</td>
								</tr>
							@endforelse
						{{-- @else
							@forelse ($items as $item)
								<tr>
									<td style="width: 10%">
										<a href="{{ asset('shop') }}/{{ $item->slug_product }}">
											<img style="width: 100%" src="{{ $item->img }}" alt="">
										</a>
									</td>

									<td id="name">
										<a href="{{ asset('shop') }}/{{ $item->slug_product }}" style="color: black">
											<p>{{ $item->name_product }}</p>
										</a>
										
										@foreach($sizes as $key => $size)
											@if($item->id_size == $size->id_size)
												<span>{{ $size->size }} </span>,
											@endif
										@endforeach
											
										@foreach($colors as $key => $color)
											@if($item->id_color == $color->id_color)
												<span>{{ $color->color }} </span>
											@endif
										@endforeach 
									</td>
									<td>
										<div>
											<form action="{{ asset('cart/update') }}" method="POST">
												@csrf
												@foreach($p_s_c as $key => $p)
													@if($item->id_color == $p->id_color && $item->id_size == $p->id_size  && $item->id_product == $p->id_product)
														@php
															$qty = $item->qty;
															$stock = $p->quantity;
														@endphp
														<input class="input-number" type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $p->quantity}}">
													@endif
												@endforeach
	
												<input type="hidden" name="rowId" value="{{ $item->id }}">
												<button type="submit" style="margin-top: 0">Cập nhật</button>
											</form> 
										</div>
										@if($qty > $stock)
											<span style="color: red">còn {{ $stock  }} sản phẩm</span>
										@else
											<span style="color: #bbb">còn {{ $stock  }} sản phẩm</span>
										@endif
									</td>
									<td>
										{{ number_format($item->price1,0,',','.')}} đ
									</td>
									<td>
										{{ number_format($item->price1*$item->qty,0,',','.')  }} đ
									</td>
									@php
										$total_price += $item->price1*$item->qty;
									@endphp
									<td>
										<a style="color: white" href="{{ asset('/cart/delete') }}/{{ $item->id }}">
											<button class="btn btn-danger">
												<i class="fas fa-trash"></i>
											</button>
										</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6">
										<b>
											GIỎ HÀNG CỦA BẠN ĐANG TRỐNG
										</b>
										<br>
										<a href="{{ asset('shop') }}">
											<button>
												MUA HÀNG
											</button>
										</a>
									</td>
								</tr>
							@endforelse
						@endguest --}}
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="container cart-total">
		<div class="row">
			<div class="col-lg-6">
			</div>
			<div class="col-lg-6">
				<table class="table" style="text-align: center">
					<thead>
						<tr>
							<th>Tạm tính</th>
						</tr>
					</thead>
					<tbody >
						<tr>
							<td> 
								<h5>
									<b>
										{{ number_format($total_price,0,',','.')  }} đ
									</b>
								</h5>
							</td>
						</tr>
						<tr style="text-align: right;">
							<td >
								@if($total_price != 0 && $qty <= $stock)
									<a href="{{ asset('checkout') }}">
										<button class="check" type="submit">Thanh toán</button>
									</a>
								@endif
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('js')
    <script>


		
	</script>
@endsection

