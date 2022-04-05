@extends('cms::layouts.admin')
@section('title', title($log->action))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.activity_logs.index') }}">لاگ فعالیت کاربران</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $log->action }}</li>
  </ol>
</nav>
<div class="table-responsive">
    <table class="table table-hover">
        <tr>
            <th>#</th>
            <td>{{ $log->id }}</td>
        </tr>
        <tr>
            <th>عملیات</th>
            <td>{{ $log->action }}</td>
        </tr>
        <tr>
            <th>شناسه کاربر</th>
            <td>{{ $log->user->id ?? 'نامشخص' }}</td>
        </tr>
        <tr>
            <th>نام کاربر</th>
            <td>{{ $log->user->name ?? 'مهمان' }}</td>
        </tr>
        <tr>
            <th>مدل مرتبط</th>
            <td>{{ $log->related_type }}</td>
        </tr>
        <tr>
            <th>شناسه</th>
            <td>{{ $log->related_id }}</td>
        </tr>
        <tr>
            <th>data</th>
            <td>{{ $log->data }}</td>
        </tr>
        <tr>
            <th>یادداشت</th>
            <td>{{ $log->note }}</td>
        </tr>
        <tr>
            <th>تاریخ ثبت</th>
            <td>{{ g2j($log->created_at) }}</td>
        </tr>
    </table>
</div>
<a class="btn btn-outline-secondary" href="{{ route('admin.activity_logs.index') }}">بازگشت</a>
@endsection
