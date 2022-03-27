@extends('layouts.admin')

@section('title', title('تیکت‌ها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مدیریت تیکت‌ها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.tickets.create') }}">
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
                <th>#</th>
                <th>کاربر مربوطه</th>
                <th>موضوع</th>
                <th>دپارتمان</th>
                <th>اولویت</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->user->name }}</td>
                <td>{{ $i->subject }}</td>
                <td>{{ $i->department }}</td>
                <td>{{ $i->priority }}</td>
                <td>{{ $i->status }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.tickets.conversations.index', $i->id) }}">مشاهده</a>
                    <a class="btn btn-warning" href="{{ route('admin.tickets.edit', $i->id) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete"
                        href="{{ route('admin.tickets.delete', $i->id) }}">حذف</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $tickets->links() }}
@endsection
