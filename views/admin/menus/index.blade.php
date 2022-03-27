@extends('layouts.admin')

@section('title', title('منوها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">منوها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.menus.create') }}">
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
                <th>نام</th>
                <th>اسلاگ</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $m)
            <tr>
                <td>{{ $m->id }}</td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->slug }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.menus.show', $m->id) }}">مشاهده</a>
                    <a class="btn btn-warning" href="{{ route('admin.menus.edit', $m->id) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.menus.delete', $m->id) }}">حذف</a>
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
{{ $menus->links() }}
@endsection
