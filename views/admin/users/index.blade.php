@extends('layouts.admin')

@section('title', title('مدیریت کاربران'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">کاربران</li>
  </ol>
</nav>

<a class="btn btn-outline-primary" href="{{ route('admin.users.create') }}">ایجاد</a>
<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#filtersContainer" aria-expanded="false" aria-controls="filtersContainer">فیلتر و جستجو</button>
<div class="mt-2 @if(!hasFilters()) collapse @endif" id="filtersContainer">
    <div class="shadow card card-body">
        <form method="get" action="{{ route('admin.users.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id">شناسه</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ request()->query('id') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request()->query('name') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mobile">موبایل</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ request()->query('mobile') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ request()->query('email') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- مهم نیست --</option>
                            <option value="active" @if(request()->query('status') == 'active') selected @endif>فعال</option>
                            <option value="blocked" @if(request()->query('status') == 'blocked') selected @endif>مسدود</option>
                            <option value="approved" @if(request()->query('status') == 'approved') selected @endif>تائید شده</option>
                            <option value="not_approved" @if(request()->query('status') == 'not_approved') selected @endif>تائید نشده</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="order_by">مرتب‌سازی بر اساس</label>
                        <select class="form-control" id="order_by" name="order_by">
                            <option value="id" @if(request()->query('order_by') == 'id') selected @endif>شناسه کاربر</option>
                            <option value="name" @if(request()->query('order_by') == 'name') selected @endif>نام</option>
                            <option value="mobile" @if(request()->query('order_by') == 'mobile') selected @endif>موبایل</option>
                            <option value="email" @if(request()->query('order_by') == 'email') selected @endif>ایمیل</option>
                            <option value="is_active" @if(request()->query('order_by') == 'is_active') selected @endif>وضعیت</option>
                            <option value="created_at" @if(request()->query('order_by') == 'created_at') selected @endif>تاریخ ثبت</option>
                            <option value="updated_at" @if(request()->query('order_by') == 'updated_at') selected @endif>تاریخ به‌روز رسانی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="order_dir">در جهت</label>
                        <select class="form-control" id="order_dir" name="order_dir">
                            <option value="DESC" @if(request()->query('order_dir') == 'DESC') selected @endif>نزولی</option>
                            <option value="ASC" @if(request()->query('order_dir') == 'ASC') selected @endif>صعودی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="per_page">تعداد کاربر در هر صفحه</label>
                        <input type="number" class="form-control" id="per_page" name="per_page" value="{{ request()->query('per_page') ?: 30 }}">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.users.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<form method="post" action="{{ route('admin.users.batch') }}" id="batch-form">
    @csrf
    <div class="table-responsive">
        <table class="table table-hover my-4">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>#</th>
                    <th>نام</th>
                    <th>موبایل</th>
                    <th>ایمیل</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><input type="checkbox" name="batch[]" value="{{ $user->id }}"></td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_active)
                        <span class="text-success">فعال</span>
                        @else
                        <span class="text-danger">مسدود</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-info" href="{{ route('admin.users.show', $user->id) }}">مشاهده</a>
                            <a class="btn btn-warning" href="{{ route('admin.users.edit', $user->id) }}">ویرایش</a>
                            <a class="btn btn-danger btn-delete" href="{{ route('admin.users.delete', $user->id) }}">حذف</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="clearfix">
        <div class="w-25 float-left">
            <div class="form-group">
                <select class="form-control" name="action" id="action">
                    <option value="" selected>عملیات گروهی</option>
                    <option value="active">ویرایش وضعیت</option>
                    <option value="verified">ویرایش احراز هویت</option>
                    <option value="roles">ویرایش نقش‌ها</option>
                    <option value="delete">حذف</option>
                </select>
            </div>
        </div>
        <div class="float-right">
            {{ $users->appends($_GET)->links() }}
        </div>
    </div>
</form>
@endsection
