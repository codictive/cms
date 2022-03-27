@extends('layouts.admin')

@section('title', title('مدیریت نقش‌ها'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">نقش‌های کاربری</li>
  </ol>
</nav>
<a class="btn btn-outline-primary" href="{{ route('admin.roles.create') }}">ایجاد</a>
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>نام</th>
                <th>اسلاگ</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->slug }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-info" href="{{route('admin.roles.permissions.show', $role->id)}}">مجوزها</a>
                        <a class="btn btn-warning" href="{{route('admin.roles.edit', $role->id)}}">ویرایش</a>
                        <a class="btn btn-danger btn-delete" href="{{route('admin.roles.delete', $role->id)}}">حذف</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
