@extends('layouts.admin')

@section('title', title('ایجاد نقش'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">نقش‌های کاربری</a></li>
    <li class="breadcrumb-item active" aria-current="page">ایجاد نقش</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.roles.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="slug">اسلاگ</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.roles.index') }}">بازگشت</a>
</form>
@endsection
