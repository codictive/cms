@extends('cms::layouts.admin')

@section('title', title('تنظیمات سیستم'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">تنظیمات سیستم</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.config.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="accordion" id="siteConfigurations">
        <div class="card">
            <div class="card-header p-1" id="generalHeading">
                <h2 class="mb-0">
                    <a class="btn btn-link btn-block text-left text-dark text-decoration-none" type="button" data-toggle="collapse" data-target="#general" aria-expanded="true" aria-controls="general">
                        عمومی
                    </a>
                </h2>
            </div>

            <div id="general" class="collapse show" aria-labelledby="generalHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="app-name">نام برنامه</label>
                                <input type="text" class="form-control" id="app-name" name="app-name"
                                    value="{{ kv('app.name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site-base_url">آدرس سایت</label>
                                <input dir="ltr" type="text" class="form-control" id="site-base_url" name="site-base_url"
                                    value="{{ kv('site.base_url') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app-slogan">شعار برنامه</label>
                        <input type="text" class="form-control" id="app-slogan" name="app-slogan"
                            value="{{ kv('app.slogan') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-1" id="authHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#auth" aria-expanded="false" aria-controls="auth">
                        اعتبارسنجی
                    </button>
                </h2>
            </div>
            <div id="auth" class="collapse" aria-labelledby="authHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-default_role">نقش پیش‌فرض کاربر جدید</label>
                                <select class="form-control" id="auth-default_role" name="auth-default_role">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach ($roles as $r)
                                    <option value="{{ $r->slug }}" @if($r->slug == kv('auth.default_role')) selected
                                        @endif>{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-guest_role">نقش کاربر مهمان</label>
                                <select class="form-control" id="auth-guest_role" name="auth-guest_role">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach ($roles as $r)
                                    <option value="{{ $r->slug }}" @if($r->slug == kv('auth.guest_role')) selected
                                        @endif>{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-login_verify">ورود به سایت نیازمند تائید ایمیل باشد</label>
                                <select class="form-control" id="auth-login_verify" name="auth-login_verify">
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="yes" @if("yes" == kv('auth.login_verify')) selected @endif>بله</option>
                                    <option value="no" @if("no" == kv('auth.login_verify')) selected @endif>خیر</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-session_expire_days">مدت‌زمان اعتبار نشست کاربر</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="auth-session_expire_days"
                                        name="auth-session_expire_days" value="{{ kv('auth.session_expire_days') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">روز</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-verify_email_token_expire_days">مدت‌زمان اعتبار توکن ایمیل تائید حساب</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="auth-verify_email_token_expire_days"
                                        name="auth-verify_email_token_expire_days"
                                        value="{{ kv('auth.verify_email_token_expire_days') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">روز</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auth-reset_password_token_expire_hours">مدت‌زمان اعتبار توکن بازیابی گذرواژه</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="auth-reset_password_token_expire_hours"
                                        name="auth-reset_password_token_expire_hours"
                                        value="{{ kv('auth.reset_password_token_expire_hours') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">ساعت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-1" id="servicesHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#services" aria-expanded="false" aria-controls="services">
                        سرویس‌ها
                    </button>
                </h2>
            </div>
            <div id="services" class="collapse" aria-labelledby="servicesHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keys-recaptcha-site_key">reCAPTCHA Site Key</label>
                                <input dir="ltr" type="text" class="form-control" id="keys-recaptcha-site_key"
                                    name="keys-recaptcha-site_key" value="{{ kv('keys.recaptcha.site_key') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keys-recaptcha-secret_key">reCAPTCHA Secret Key</label>
                                <input dir="ltr" type="text" class="form-control" id="keys-recaptcha-secret_key"
                                    name="keys-recaptcha-secret_key" value="{{ kv('keys.recaptcha.secret_key') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="keys-adsense-publisher_id">AdSense Publisher ID</label>
                                <input dir="ltr" type="text" class="form-control" id="keys-adsense-publisher_id"
                                    name="keys-adsense-publisher_id" value="{{ kv('keys.adsense.publisher_id') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="keys-payment-paypal_api_key">Paypal API Key</label>
                                <input dir="ltr" type="text" class="form-control" id="keys-payment-paypal_api_key"
                                    name="keys-payment-paypal_api_key" value="{{ kv('keys.payment.paypal_api_key') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-1" id="contactsHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#contacts" aria-expanded="false" aria-controls="contacts">
                        پل‌های ارتباطی
                    </button>
                </h2>
            </div>
            <div id="contacts" class="collapse" aria-labelledby="contactsHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact-phone">تلفن</label>
                                <input dir="ltr" type="text" class="form-control" id="contact-phone" name="contact-phone"
                                    value="{{ kv('contact.phone') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact-email">ایمیل</label>
                                <input dir="ltr" type="email" class="form-control" id="contact-email" name="contact-email"
                                    value="{{ kv('contact.email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-facebook">فیسبوک</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-facebook"
                                    name="social_media-facebook" value="{{ kv('social_media.facebook') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-twitter">توییتر</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-twitter"
                                    name="social_media-twitter" value="{{ kv('social_media.twitter') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-youtube">یوتیوب</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-youtube"
                                    name="social_media-youtube" value="{{ kv('social_media.youtube') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-telegram">تلگرام</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-telegram"
                                    name="social_media-telegram" value="{{ kv('social_media.telegram') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-instagram">اینستاگرام</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-instagram"
                                    name="social_media-instagram" value="{{ kv('social_media.instagram') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-whatsapp">واتس‌اپ</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-whatsapp"
                                    name="social_media-whatsapp" value="{{ kv('social_media.whatsapp') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="social_media-linkedin">لینکداین</label>
                                <input dir="ltr" type="text" class="form-control" id="social_media-linkedin"
                                    name="social_media-linkedin" value="{{ kv('social_media.linkedin') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-1" id="searchHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                        جستجو
                    </button>
                </h2>
            </div>
            <div id="search" class="collapse" aria-labelledby="searchHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search-min_query_length">حداقل طول عبارت جستجو</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="search-min_query_length"
                                        name="search-min_query_length"
                                        value="{{ kv('search.min_query_length') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">کاراکتر</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cache-categories-ttl">مدت زمان اعتبار کش دسته‌بندی</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="cache-categories-ttl" name="cache-categories-ttl"
                                        value="{{ kv('cache.categories.ttl') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">دقیقه</span>
                                    </div>
                                </div>
                                <small class="text-muted">0 = دائمی</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search-replace_persian_arabic">تبدیل کاراکترهای فارسی و عربی</label>
                                <select class="form-control" id="search-replace_persian_arabic" name="search-replace_persian_arabic">
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="p2a" @if('p2a' == kv('search.replace_persian_arabic')) selected @endif>تبدیل فارسی به عربی</option>
                                    <option value="a2p" @if('a2p' == kv('search.replace_persian_arabic')) selected @endif>تبدیل عربی به فارسی</option>
                                    <option value="off" @if('off' == kv('search.replace_persian_arabic')) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search-remove_tanvin">حذف تنوین و اعراب</label>
                                <select class="form-control" id="search-remove_tanvin" name="search-remove_tanvin">
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="on" @if('on' == kv('search.remove_tanvin')) selected @endif>فعال</option>
                                    <option value="off" @if('off' == kv('search.remove_tanvin')) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search-remove_nonletter_characters">حذف کاراکترهای علائم مثل / ) ( : ;</label>
                                <select class="form-control" id="search-remove_nonletter_characters" name="search-remove_nonletter_characters">
                                    <option value="">-- انتخاب کنید --</option>
                                    <option value="on" @if('on' == kv('search.remove_nonletter_characters')) selected @endif>فعال</option>
                                    <option value="off" @if('off' == kv('search.remove_nonletter_characters')) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-1" id="miscHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#misc" aria-expanded="false" aria-controls="misc">
                        متفرقه
                    </button>
                </h2>
            </div>
            <div id="misc" class="collapse" aria-labelledby="miscHeading" data-parent="#siteConfigurations">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="api-default_per_page">وب اپلیکیشن: تعداد پیش‌فرض آیتم‌های صفحه</label>
                                <input type="number" class="form-control" id="api-default_per_page" name="api-default_per_page"
                                    value="{{ kv('api.default_per_page') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="app-book-max_picture_count">حداکثر تعداد تصاویر کتاب</label>
                                <input type="number" class="form-control" id="app-book-max_picture_count" name="app-book-max_picture_count"
                                    value="{{ kv('app.book.max_picture_count') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="app-book-max_picture_size">حداکثر سایز تصاویر کتاب</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="app-book-max_picture_size" name="app-book-max_picture_size"
                                        value="{{ kv('app.book.max_picture_size') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">کیلوبایت</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="site-meta-keywords">کلیدواژه‌های متا</label>
                        <textarea rows="5" class="form-control" id="site-meta-keywords"
                            name="site-meta-keywords">{{ kv('site.meta.keywords') }}</textarea>
                        <small class="form-text">هر مورد را در یک خط بنویسید.</small>
                    </div>
                    <div class="form-group">
                        <label for="site-meta-description">توضیحات متا</label>
                        <textarea rows="3" class="form-control" id="site-meta-description"
                            name="site-meta-description">{{ kv('site.meta.description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" class="mt-3 btn btn-success" value="ذخیره">
</form>
@endsection
