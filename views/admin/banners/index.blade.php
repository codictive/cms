@extends('layouts.admin')

@section('title', title('مدیریت بنرهای تبلیغاتی'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">بنرها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.ad_banners.create') }}">
                    <i class="fas fa-add"></i>
                    ایجاد
                </a>
            </div>
            <form class="d-flex ms-auto" action="" method="post">
                <div class="input-group">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-filter"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="جستجو...">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>نام</th>
                <th>نوع</th>
                <th>سایز <sup>کیلوبایت</sup></th>
                <th>لینک</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $b)
            <tr>
                <td>{{ $b->name }}</td>
                <td>
                    @switch($b->kind)
                        @case('image')
                            عکس
                            @break
                        @case('video')
                            فیلم
                            @break
                        @case('audio')
                            صوت
                            @break
                        @default
                            نامشخص
                    @endswitch
                </td>
                <td>{{ persianNumberFormat($b->size / 1024) }}</td>
                <td><span dir="ltr">{{ $b->link }}</span></td>
                <td>
                    <a class="btn btn-info" href="/static/banners/{{ $b->file_name }}" target="blank">مشاهده</a>
                    <a class="btn btn-warning" href="{{route('admin.ad_banners.edit', $b->id)}}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete"
                        href="{{route('admin.ad_banners.delete', $b->id)}}">حذف</a>
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
