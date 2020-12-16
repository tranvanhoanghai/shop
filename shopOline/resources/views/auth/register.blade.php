@extends('layouts.theme')
@section('title','Tums - Đăng kí')

@section('css')
    <link href="{{ asset('css/front-end/login_reg.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="user">
        <div class="user_options-container">
            <div class="user_options-text">
                <div class="user_options-unregistered">
                    <h2 class="user_unregistered-title">Bạn chưa có tài khoản</h2>
                    <p class="user_unregistered-text" style="visibility: hidden;">Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap.</p>
                    <button class="user_unregistered-signup" id="signup-button">Đăng kí</button>
                </div>

                <div class="user_options-registered">
                    <h2 class="user_registered-title">Bạn đã có tài khoản</h2>
                    <p class="user_registered-text" style="visibility: hidden;">Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap.</p>
                    <a href="{{ route('login') }}"><button class="user_registered-login">Đăng nhập</button></a>
                </div>
            </div>

            <div class="user_options-forms bounceLeft" id="user_options-forms">
                <div class="user_forms-signup">
                    <h2 class="forms_title">ĐĂNG KÍ</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="forms_fieldset">
                            <div class="forms_field">
                                <input id="name" type="text" class="forms_field-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" placeholder="Họ tên">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="forms_field">
                                <input id="email" type="email" class="forms_field-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="forms_field">
                                <input id="password" type="password" class="forms_field-input @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Mật khẩu">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="forms_field">
                                <input id="password-confirm" type="password" class="forms_field-input" name="password_confirmation" required autocomplete="off" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-dark">
                                    {{ __('Đăng kí') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
              
@endsection
@section('js')
    <script>
        $(window).on('load', function() {
            $('.load').fadeOut('fast');
        });
    </script>
@endsection
