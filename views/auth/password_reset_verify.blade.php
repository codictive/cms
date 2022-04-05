@extends('cms::layouts.auth')

@section('title', title('بازیابی گذرواژه'))

@section('content')
<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.show_login_form') }}">ورود</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.show_password_login_form') }}">ورود با گذرواژه</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('auth.show_password_reset_request_form') }}">بازیابی گذرواژه</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('auth.password_reset_verify') }}">
            @csrf
            <div class="form-group">
                <label for="code">کد احراز هویت</label>
                <input type="number" class="form-control" id="code" name="code" required autofocus autocomplete="off">
                <small class="form-text">زمان باقی‌مانده: <span id="timer"></span></small>
            </div>
            <div class="form-group">
                <label for="password">گذرواژه جدید</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="submit" class="btn btn-outline-primary" value="ورود">
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var expiresAt = new Date().getTime() + ({{kv('auth.verification_sms.expires_at')}} * 1000);
        var timer = $('#timer');

        var fmt = function (n){
            return n > 9 ? ("" + n) : ("0" + n);
        }

        var t = setInterval(function () {
            var now = new Date().getTime();
            var diff = expiresAt - now;

            if (diff <= 0) {
                clearInterval(t);
                window.location.href = '{{ route('auth.show_login_form') }}';
                return;
            }

            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);

            timer.html(fmt(minutes) + ':' + fmt(seconds));
        }, 1000);
    });
</script>
@endsection
