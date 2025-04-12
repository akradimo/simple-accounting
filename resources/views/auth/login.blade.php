@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('ورود به سیستم') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('ایمیل') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('رمز عبور') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('مرا به خاطر بسپار') }}
                            </label>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('ورود') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                                </a>
                            @endif

                            <!-- اضافه کردن لینک ثبت نام -->
                            <div class="mt-3">
                                <p class="text-center">
                                    حساب کاربری ندارید؟ 
                                    <a href="{{ route('register') }}" class="text-primary">
                                        ثبت نام کنید
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    padding: 1rem;
    font-size: 1.2rem;
    font-weight: 500;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
}

.btn-primary {
    border-radius: 8px;
    padding: 0.75rem 2rem;
}
</style>
@endsection