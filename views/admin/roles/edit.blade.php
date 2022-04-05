@extends('cms::layouts.admin')

@section('title', title($role->name))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">نقش‌های کاربری</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.roles.update', $role->id) }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="slug">اسلاگ</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ $role->slug }}" required>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.roles.index') }}">بازگشت</a>
</form>
@endsection
