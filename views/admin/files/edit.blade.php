@extends('layouts.admin')
@section('title', title($file->caption ?? 'ویرایش فایل'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.files.index') }}">فایل‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $file->caption ?? 'ویرایش' }}</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.files.update', $file->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="caption">کپشن</label>
        <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption', $file->caption) }}">
        @error('caption')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="file">فایل</label>
        @if($file->filename)
        <div>
            <a class="btn btn-info" href="/static/files/{{ $file->filename }}">مشاهده فایل</a>
            <div class="mt-2 text-muted">تنها جهت تغییر فایل فعلی، فایل جدیدی انتخاب کنید.</div>
        </div>
        @endif
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
        @error('file')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">توضیحات</label>
        <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $file->description) }}</textarea>
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
