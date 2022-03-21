@extends('layouts.auth')

@section('title', title('بازیابی گذرواژه'))

@section('content')
<section id="content">
    <div class="mobile-header">
        <a href="/">
            <img src="/static/img/{{ kv('site.logo_small') }}">
        </a>
    </div>
    <div class="login-content">
        <header class="login-header">
            <h1>بازیابی گذرواژه</h1>
            <a href="/">
                <img src="/static/img/{{ kv('site.logo_small') }}">
            </a>
        </header>
        <form method="post" action="{{ route('auth.password_reset_verify') }}">
            @csrf
            <section id="enter-mobile">
                <div class="login-box">
                    <div class="login-box-title">
                        <div class="entered-phone-wrapper">
                            <span class="entered-phone-label"></span>
                        </div>
                    </div>
                    <div class="login-box-input">
                        <label for="code">کد ارسال شده:</label>
                        <input type="number" id="code" name="code" autocomplete="off" autofocus required>
                    </div>
                    <div class="login-box-input">
                        <label for="password">گذرواژه جدید:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
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
</section>
@endsection
