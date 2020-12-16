@extends('layouts.theme')
@section('title','Xác thực email - Tums')

@section('css')
	<link href="{{ asset('css/front-end/login_reg.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >
                    <span style="font-size: 17px">{{ __('Xác thực địa chỉ email của bạn') }}</span>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <span style="font-size: 17px">{{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}</span>
                        </div>
                    @endif

                    <span style="font-size: 17px">{{ __('Trước khi tiếp tục, vui lòng kiểm tra email của bạn để biết liên kết xác minh,') }}</span>
                    <span style="font-size: 17px">{{ __('Nếu bạn không nhận được email.') }},</span>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('bấm vào đây để thử lại') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
