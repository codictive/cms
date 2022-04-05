@extends('cms::layouts.admin')

@section('title', title('ایجاد بنر تبلیغاتی'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.ad_banners.index') }}">بنرها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد بنر</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<form method="post" action="{{ route('admin.ad_banners.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="required" for="name">نام</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name') }}" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="required" for="file">فایل</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
        @error('file')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="link">لینک</label>
        <input type="text" dir="ltr" class="form-control @error('link') is-invalid @enderror" id="link" name="link"
            value="{{ old('link') }}">
        @error('link')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.ad_banners.index') }}">بازگشت</a>
</form>
@endsection
