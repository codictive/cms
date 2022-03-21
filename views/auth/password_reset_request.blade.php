@extends('cms::layouts.auth')

@section('title', title('بازیابی گذرواژه'))

@section('content')
<div class="mobile-header">
    <a href="/">
        <img src="/static/img/{{ kv('site.logo_small') }}">
    </a>
</div>
<div class="login-content">
    <header class="login-header">
        <h1>بازیابی رمز عبور</h1>
        <a href="/">
            <img src="/static/img/{{ kv('site.logo_small') }}">
        </a>
    </header>
    <span id="loader-signin" style="display: none;">
        <span class="loader-inner ball-pulse">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </span>
    <form method="post" action="{{ route('auth.password_reset_request') }}">
        @csrf
        <section id="enter-mobile">
            <div class="login-box">
                <div class="login-box-title">
                    <div class="entered-phone-wrapper">
                        <span class="entered-phone-label"></span>
                    </div>
                </div>
                <div class="login-box-input">
                    <label for="mobile">شماره موبایل:</label>
                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" maxlength="11" minlength="11" autofocus required>
                </div>
                <div class="g-recaptcha mb-3" data-sitekey="{{ kv('keys.recaptcha.site_key') }}"
                    style="direction:ltr;"></div>
                <div class="login-box-cta">
                    <button id="enter-mobile-cta" type="submit">
                        ادامــه
                    </button>
                </div>
                <div class="login-footer">
                    <div id="cp-section">
                        <div class="cp-box-info">
                            <p id="cp-message">
                                ورود شما به معنای موافقت با <a href="/pages/terms" target="_blank">قوانین {{ appName() }}</a>
                                است.
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
