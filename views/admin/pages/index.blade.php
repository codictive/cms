@extends('cms::layouts.admin')

@section('title', title('صفحات استاتیک'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">صفحات استاتیک</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.pages.create') }}">
                    <i class="fas fa-add"></i>
                    ایجاد
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
                <th>عنوان</th>
                <th>اسلاگ</th>
                <th>تعداد بازدید</th>
                <th>منتشر شده</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->title }}</td>
                <td>{{ $p->slug }}</td>
                <td>{{ number_format($p->hits) }}</td>
                <td>
                    @if($p->published)
                    <span class="text-success">منتشر شده</span>
                    @else
                    <span class="text-danger">منتشر نشده</span>
                    @endif
                </td>
                <td>{{ g2j($p->created_at) }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('site.pages.show', $p->slug) }}">مشاهده</a>
                    <a class="btn btn-warning" href="{{ route('admin.pages.edit', $p->id) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete"
                        href="{{ route('admin.pages.delete', $p->id) }}">حذف</a>
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
{{ $pages->links() }}
@endsection
