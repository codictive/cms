@extends('cms::layouts.admin')

@section('title', title('ایجاد برچسب'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">برچسب‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">ایجاد برچسب</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.tags.store') }}">
    @csrf
    <div class="col-12">
        <div class="form-group">
            <label for="name">نام</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">توضیحات</label>
            <textarea rows="4" class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.tags.index') }}">بازگشت</a>
</form>
@endsection
