@extends('cms::layouts.admin')
@section('title', title($province->name))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.provinces.index') }}">مدیریت استان‌ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد شهر برای '{{ $province->name }}'</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.cities.create', $province->id) }}">
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
            @forelse ($cities as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->weight }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.cities.show', [$province->id, $c->id]) }}">محله‌ها</a>
                    <a class="btn btn-warning" href="{{ route('admin.cities.edit', [$province->id, $c->id]) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.cities.delete', [$province->id, $c->id]) }}">حذف</a>
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
<a class="btn btn-outline-secondary" href="{{ route('admin.provinces.index') }}">بازگشت</a>
@endsection
