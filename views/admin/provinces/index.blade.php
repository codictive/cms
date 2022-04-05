@extends('cms::layouts.admin')
@section('title', title('مدیریت استان‌ها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مدیریت استان‌ها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.provinces.create') }}">
                    <i class="fas fa-add"></i>
                    ایجاد
                </a>
            </div>
        </div>
    </div>
</nav>
<div class="table-responsive mt-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>وزن</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($provinces as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->weight }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.provinces.show', $p->id) }}">شهرها</a>
                    <a class="btn btn-warning" href="{{ route('admin.provinces.edit', $p->id) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.provinces.delete', $p->id) }}">حذف</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
