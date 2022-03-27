@extends('layouts.admin')

@section('title', title('ایجاد صفحه استاتیک'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">صفحات استاتیک</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد صفحه استاتیک</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<h1 class="fw-200">ایجاد صفحه استاتیک</h1>
<form method="post" class="mt-2" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title">عنوان</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="slug">اسلاگ</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="headline">سرتیتر</label>
                <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline" name="headline" value="{{ old('headline') }}">
                @error('headline')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image">تصویر اصلی</label>
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="summary">خلاصه</label>
                <textarea rows="3" class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary">{{ old('summary') }}</textarea>
                @error('summary')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body">متن کامل</label>
                <textarea rows="6" class="form-control @error('body') is-invalid @enderror" id="body" name="body" required>{{ old('body') }}</textarea>
                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <div class="checkbox">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="custom-control-input" id="published" name="published">
                        <label for="published" class="custom-control-label mt-1">
                            <span class="pr-4">صفحه منتشر شود.</span>
                        </label>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.pages.index') }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="/lib/ckeditor/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    CKEDITOR.replace('body', {language: "fa"});
});
</script>
@endsection
