@extends('layouts.theme')
@section('title','Sản phẩm - Tums')

@section('css')
	{{-- style shop --}}
	<link href="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.css" rel="stylesheet">
	<link href="{{ asset('css/front-end/item.css') }}" rel="stylesheet">
	<link href="{{ asset('css/front-end/shop.css') }}" rel="stylesheet">
@endsection
@section('style') 
	<style>
		#shop li .active{
			height: 2px;
		}
	</style>
@endsection 
@section('content')
<div class="masks">
</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<img src="" alt="">
			</div>
		</div>
	</div>

	{{-- breadcrumb  --}}
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<nav aria-label="breadcrumb" >
				  <ol class="breadcrumb" style="background: none;">
				    <li class="breadcrumb-item"><a href="{{ asset('/') }}">Home</a></li>
				    <li class="breadcrumb-item active">Shop</li>
				  </ol>
				</nav>
			</div>
			<div class="col-sm-2 col-3 hide">
				<div class="btn-filter">
					<i class="fas fa-filter"></i>
				</div>
			</div>
			<div class="col-lg-3 col-sm-10 col-9 select ">
				<form action="{{ asset('/shop/sortby/') }}" method="post" id="formSort">
					@csrf
					<select name="sortBy" id="sortBy" class="form-control">
						@isset($sort)
							@switch($sort)
								@case('priceAsc')
									<option value="">Mặc định</option>
									<option value="priceAsc"selected>Giá tăng dần </option>
									<option value="priceDesc">Giá giảm dần</option>
									<option value="newProduct">Hàng mới nhất</option>
									<option value="oldProduct">Hàng cũ nhất</option>
									@break
								@case('priceDesc')
									<option value="" >Mặc định</option>
									<option value="priceAsc">Giá tăng dần </option>
									<option value="priceDesc"selected>Giá giảm dần</option>
									<option value="newProduct">Hàng mới nhất</option>
									<option value="oldProduct">Hàng cũ nhất</option>
									@break
								@case('newProduct')
									<option value="">Mặc định</option>
									<option value="priceAsc">Giá tăng dần </option>
									<option value="priceDesc">Giá giảm dần</option>
									<option value="newProduct"selected>Hàng mới nhất</option>
									<option value="oldProduct">Hàng cũ nhất</option>
									@break
								@case('oldProduct')
									<option value="">Mặc định</option>
									<option value="priceAsc">Giá tăng dần </option>
									<option value="priceDesc">Giá giảm dần</option>
									<option value="newProduct">Hàng mới nhất</option>
									<option value="oldProduct"selected>Hàng cũ nhất</option>
									@break
								@default
							@endswitch
						@endisset
						@if (!isset($sort))
							<option value=""selected>Mặc định</option>
							<option value="priceAsc">Giá tăng dần </option>
							<option value="priceDesc">Giá giảm dần</option>
							<option value="newProduct">Hàng mới nhất</option>
							<option value="oldProduct">Hàng cũ nhất</option>
						@endif
					</select>
				</form>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="option">
					<div class="close-btn">
						<i class="fas fa-times"></i>
					</div>
					<div class="search">
						<form action="{{ asset('/shop/search') }}" method="POST" id="formSearch">
							@csrf
							<input type="search" id="search" placeholder="Tìm kiếm sản phẩm" required style="outline: none">
							@isset($key)
							<br>
							<br>
                                <span style="display: block">Từ khoá cho :
                                    <b>{{ $key }}</b><a style="margin-left: 10px" href="{{ asset('shop') }}"><i class="fas fa-times"></i></a>
                                </span>
                            @endisset
							<button class="btn-search" type="submit">TÌM</button>
						</form>
					</div>

					<div class="filter">
						<p>KHOẢNG GIÁ</p>
						<hr>
						<div id="slider"></div>
						<form action="{{ asset('/shop/filter/') }}" method="POST">
							@csrf
							<span>Giá từ</span>
							<input  id="exTO" type="number" name="up" readonly value="">
							<span>đến</span>
							<input  id="exFR" type="number" name="to" readonly value="">
							<button class="fil" type="submit">ÁP DỤNG</button>
						</form>
					</div>
					<p>DANH MỤC SẢN PHẨM</p>
					<hr>
					@foreach($cates as $value)
						<ul style="padding: 0" >
							<li class="nav-item"> 
								<i class="fas fa-star-of-life" style="font-size: 8px; color: #bbb"></i> &emsp;
								<a href="{{ asset('/category/'.$value->name_product_type) }}" style="color: black;text-transform: uppercase">
									{{ $value->name_product_type }}
								</a>
							</li>
						</ul>
					@endforeach
				</div>
			</div>
			<div class="col-lg-9">
				<div class="row">
					@forelse($product as $value)
						<div class="col-lg-4 col-sm-4 col-6 new-product">
							<div class="cart-item item">
								<?php
									$ds = [];		
								?> 
								@foreach($image as $img) 
									@if($value->id_product == $img->id_product)
										<?php
											array_push($ds, $img->image);
										?>
									@endif
								@endforeach
								<div class="img-product">
									<a href="{{ asset('/shop/') }}/{{ $value->slug_product }}" title="">
										<div class="front">
											<img src="{{ $ds[0] }}">
										</div>
										<div class="back">
												<img src="{{ $ds[1] }}">
										</div>
									</a>
									@foreach($sold as $s)
										@if($value->id_product == $s->id_product)
											<div class="sold">SOLD OUT</div>
										@endif
									@endforeach
								</div>
								<div class="info">
									<br>
									<span >{{ $value->name_product }}</span>
									<span>{{ number_format($value->price1,0,',','.') }} đ</span>
								</div>
							</div>
						</div>
					@empty
						<div class="col-lg-12 text-center">
							<h1>KHÔNG TÌM THẤY KẾT QUẢ PHÙ HỢP</h1>
						</div>	
					@endforelse
				</div> {{-- row --}}
				{{ $product->links() }}
			</div> {{-- col-lg-9 --}}
		</div> {{-- row --}} 
	</div> {{-- container --}}
@endsection

{{-- SCRIPT --}}
@section('js')
	<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
	<script src="{{asset('js/owl.carousel.js') }}"></script>
	<script>
		
		$('.btn-search').click(function(){
            var key =  $('#search').val();
            $('#formSearch').attr('action', '{{ asset("/shop/search") }}/' +key);
        });

		$('#sortBy').change(function(){
            var key =  $('#sortBy').val();
			if(key == ''){
				window.location = '{{ asset("shop") }}';
			}else{
				$('#formSort').attr('action', '{{ asset("/shop/sortBy") }}/' +key);
            	$('#formSort').submit();
			}
        });
	
		var stepsSlider = document.getElementById('slider');
		var input0 = document.getElementById('exTO');
		var input1 = document.getElementById('exFR');
		var inputs = [input0, input1];

		noUiSlider.create(stepsSlider, {
		    start: [100000, 1000000],
		    step: 10000,
		    connect: true,
		      animationDuration: 300,

		    range: {
		        'min': 100000,
		        'max': 1000000
		    }
		});
		stepsSlider.noUiSlider.on('update', function (values, handle) {
		    inputs[handle].value = values[handle];
		})

		$('.btn-filter').click(function(){
			$('.option').css("left", "0px");
			$('.masks').css("width", "100%");
		});
		$('.close-btn').click(function(){
			$('.option').css("left","-125%");
			$('.masks').css("width", "0%");
		});

	
	</script>
@endsection