@extends('layouts.theme')
@section('title','Tums - Đăng nhập')

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
                    <a href="{{ route('register') }}"><button class="user_registered-login" id="login-button">Đăng kí</button></a>
                </div>

                <div class="user_options-registered">
                    <h2 class="user_registered-title">Bạn đã có tài khoản</h2>
                    <p class="user_registered-text" style="visibility: hidden;">Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap.</p>
                    <a href="{{ route('register') }}"><button class="user_registered-login" id="login-button">Đăng nhập</button></a>
                </div>
            </div>

            <div class="user_options-forms bounceRight" id="user_options-forms">
                <div class="user_forms-login">
                    <h2 class="forms_title">Đăng nhập</h2>
                    <form method="POST" action="{{ route('login') }}"> 
                        @csrf
                        <div class="forms_fieldset">
                            <div class="forms_field">
                                   
                                <input id="email" type="email" class=" forms_field-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="forms_field">
                                <input id="password" type="password" class="forms_field-input @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">

                                <div class="form-check">
                                    <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ghi nhớ') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-outline-dark">
                                    {{ __('Đăng nhập') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Quên mật khẩu?') }}
                                    </a>
                                @endif
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