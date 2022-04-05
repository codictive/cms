@extends('cms::layouts.admin')

@section('title', title('ایجاد کاربر'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
    <li class="breadcrumb-item active" aria-current="page">ایجاد کاربر</li>
  </ol>
</nav>
<form method="post" action="{{route('admin.users.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="مرتضی" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">موبایل</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="09123456789" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">گذرواژه</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="image">تصویر</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>نقش‌ها</label>
        @forelse($roles as $role)
        <div class="form-check">
            <label>
                <input type="checkbox" class="form-check-input" name="roles[]" value="{{$role->id}}">
                {{ $role->name }}
            </label>
        </div>
        @empty
        <p class="text-muted">موردی جهت نمایش وجود ندارد.</p>
        @endforelse
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>وضعیت</label>
            <div class="form-check">
                <label>
                    <input type="checkbox" class="form-check-input" name="is_verified" id="is_verified">
                    کاربر احراز هویت شده است.
                </label>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{route('admin.users.index')}}">بازگشت</a>
</form>
@endsection
