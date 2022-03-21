@extends('layouts.auth')

@section('title', title('تسجيل'))

@section('content')
<div class="card">
    <div class="card-header">تسجيل</div>
    <div class="card-body">
        <form id="registerForm" method="post" action="{{ route('auth.register') }}">
            @csrf
            <div class="form-group">
                <label class="required" for="name">اسم</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
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
                <label for="mobile">رقم الهاتف المحمول</label>
                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}">
                @error('mobile')
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
            <div class="form-group">
                <label class="required" for="password_confirmation">التأكيد كلمه السر</label>
                <input type="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="g-recaptcha btn btn-success"
            data-sitekey="{{ kv('keys.recaptcha.site_key') }}"
            data-callback='onSubmit'
            data-action='submit'>تسجيل</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function onSubmit() {
        $('#registerForm').trigger('submit');
    }
</script>
@endsection
