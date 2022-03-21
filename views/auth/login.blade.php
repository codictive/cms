@extends('layouts.auth')

@section('title', title('تسجيل الدخول'))

@section('content')
<div class="card">
    <div class="card-header">تسجيل الدخول</div>
    <div class="card-body">
        <form id="loginForm" method="post" action="{{ route('auth.login') }}">
            @csrf
            <div class="form-group">
                <label class="required" for="email">البريد الإلكتروني</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="required" for="password">كلمه السر</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="g-recaptcha btn btn-success"
            data-sitekey="{{ kv('keys.recaptcha.site_key') }}"
            data-callback='onSubmit'
            data-action='submit'>دخول</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function onSubmit() {
        $('#loginForm').trigger('submit');
    }
</script>
@endsection
