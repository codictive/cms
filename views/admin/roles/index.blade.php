@extends('cms::layouts.admin')

@section('title', title('مدیریت نقش‌ها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مدیریت نقش‌ها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.roles.create') }}">
                    <i class="fas fa-add"></i>ایجاد
                </a>
            </div>
        </div>
    </div>
</nav>
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
