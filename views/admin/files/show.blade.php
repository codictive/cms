@extends('cms::layouts.admin')
@section('title', title($file->caption ?? 'جزئیات فایل'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.files.index') }}">فایل‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $file->caption ?? 'جزئیات' }}</li>
  </ol>
</nav>
<div class="table-responsive">
    <table class="table table-hover">
        <tr>
            <th>لینک مستقیم</th>
            <td dir="ltr">
                <a href="/static/files/{{ $file->filename }}" target="_blank">/static/files/{{ $file->filename }}</a>
            </td>
        </tr>
        <tr>
            <th>شناسه</th>
            <td>{{ $file->id }}</td>
        </tr>
        <tr>
            <th>کپشن</th>
            <td>{{ $file->caption }}</td>
        </tr>
        <tr>
            <th>نوع مدل مرتبط</th>
            <td>{{ $file->related_type }}</td>
        </tr>
        <tr>
            <th>شناسه مدل مرتبط</th>
            <td>{{ $file->related_id }}</td>
        </tr>
        <tr>
            <th>نام فایل</th>
            <td>{{ $file->filename }}</td>
        </tr>
        <tr>
            <th>نوع فایل</th>
            <td>{{ $file->kind }}</td>
        </tr>
        <tr>
            <th>mimetype</th>
            <td>{{ $file->mimetype }}</td>
        </tr>
        <tr>
            <th>حجم <sup>کلیوبایت</sup></th>
            <td>{{ number_format($file->size / 1024) }}</td>
        </tr>
        <tr>
            <th>توضیحات</th>
            <td>{!! nl2br($file->description) !!}</td>
        </tr>
        <tr>
            <th>تاریخ ثبت</th>
            <td>{{ g2j($file->created_at) }}</td>
        </tr>
        <tr>
            <th>تاریخ به‌روز رسانی</th>
            <td>{{ g2j($file->updated_at) }}</td>
        </tr>
    </table>
</div>
<a class="btn btn-outline-secondary" href="{{ route('admin.files.index') }}">بازگشت</a>
@endsection
