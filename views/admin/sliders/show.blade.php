@extends('cms::layouts.admin')

@section('title', title($slider->name))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">مدیریت اسلایدرها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $slider->name }}</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.sliders.items.create', $slider->id) }}">
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
                <th>#</th>
                <th>کپشن</th>
                <th>مسیر</th>
                <th>وزن</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->caption }}</td>
                <td><span dir="ltr">{{ $i->link }}</span></td>
                <td>{{ $i->weight }}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.sliders.items.edit', [$slider->id, $i->id]) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.sliders.items.delete', [$slider->id, $i->id]) }}">حذف</a>
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
<a class="btn btn-outline-secondary" href="{{ route('admin.sliders.index') }}">بازگشت</a>
@endsection
