@extends('layouts.admin')
@section('title', title('ایجاد فایل'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.files.index') }}">فایل‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">ایجاد فایل</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.files.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="caption">کپشن</label>
        <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption') }}">
        @error('caption')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label class="required" for="file">فایل</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
        @error('file')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">توضیحات</label>
        <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.files.index') }}">بازگشت</a>
</form>
@endsection
