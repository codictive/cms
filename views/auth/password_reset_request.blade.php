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
        <form method="post" action="{{ route('auth.password_reset_request') }}" id="passwordResetForm">
            @csrf
            <div class="form-group">
                <label for="mobile">تلفن همراه</label>
                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="09123456789" required autofocus>
            </div>
            <button class="g-recaptcha btn btn-success"
                data-sitekey="{{ kv('keys.recaptcha.site_key') }}"
                data-callback='onSubmit'
                data-action='submit'>ادامه</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function onSubmit() {
        $('#passwordResetForm').trigger('submit');
    }
</script>
@endsection
