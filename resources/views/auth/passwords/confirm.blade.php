@extends('admin')
@section('title', 'Travelix | Xác nhận')
@section('content')
    <marquee direction="right" class="text-white header-login">Chào mừng bạn đến với trang xác nhận mật khẩu của Travelix</marquee>
<div class="login-box">
    <h2 class="uppercase">Xác nhận mật khẩu</h2>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="user-box">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            <label for="password">Mật khẩu của bạn</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if (Route::has('password.request'))
            <div class="text-center repassword-dev password-confirm-dev">
                <a class=" text-white" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            </div>
        @endif
        <button type="submit" class="btn-register" href="#">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Xác Nhận Mật Khẩu
        </button>
        <div class="text-center mt-8 question-user">
            <span class="text-white">Bạn đã có tài khoản chưa?</span>
            <a href="{{ route('login') }}" class="text-white ml-2">Đăng nhập ngay</a>
        </div>
    </form>
</div>
@endsection