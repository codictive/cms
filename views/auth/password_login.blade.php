@extends('layouts.auth')

@section('title', title('ورود به پروفایل'))

@section('content')
<div class="mobile-header">
    <a href="/">
        <img src="/static/img/{{ kv('site.logo_small') }}">
    </a>
</div>

<div class="login-content">
    <header class="login-header">
        <h1>ورود</h1>
        <a href="/">
            <img src="/static/img/{{ kv('site.logo_small') }}">
        </a>
    </header>
    <form method="post" action="{{ route('auth.password_login') }}">
        @csrf
        <section id="enter-mobile">
            <div class="login-box">
                <div class="login-box-title">
                    <div class="entered-phone-wrapper">
                        <span class="entered-phone-label"></span>
                        <a href="{{ route('auth.show_login_form') }}">ورود با کد یک‌بار مصرف</a>
                    </div>
                </div>
                <div class="login-box-input">
                    <label for="mobile">شماره موبایل:</label>
                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" maxlength="11" minlength="11" autofocus required>
                </div>
                <div class="login-box-input">
                    <label for="password">گذرواژه:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="g-recaptcha mb-3" data-sitekey="{{ kv('keys.recaptcha.site_key') }}" style="direction:ltr;">
                </div>
                <div class="login-box-cta">
                    <h4><a href="{{ route('auth.show_password_reset_request_form') }}" id="recovery-password">بازیابی
                            رمز عبور</a></h4>
                    <button id="enter-mobile-cta" type="submit">
                        ادامــه
                    </button>
                </div>
                <div class="login-footer">
                    <div id="cp-section">
                        <div class="cp-box-info">
                            <p id="cp-message">
                                ورود شما به معنای موافقت با <a href="/pages/terms" target="_blank">قوانین {{ appName() }}</a> است.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

<br /><br /><br /><br /><br />
@endsection
