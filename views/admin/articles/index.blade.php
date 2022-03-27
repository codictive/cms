@extends('layouts.admin')

@section('title', title('مقالات وبلاگ'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مقالات</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.articles.create') }}">
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
                <th>عنوان</th>
                <th>اسلاگ</th>
                <th>تعداد بازدید</th>
                <th>منتشر شده</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->title }}</td>
                <td>{{ $a->slug }}</td>
                <td>{{ number_format($a->hits) }}</td>
                <td>
                    @if($a->published)
                    <span class="text-success">منتشر شده</span>
                    @else
                    <span class="text-danger">منتشر نشده</span>
                    @endif
                </td>
                <td>{{ g2j($a->created_at) }}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.articles.edit', $a->id) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.articles.delete', $a->id) }}">حذف</a>
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
{{ $articles->links() }}
@endsection
