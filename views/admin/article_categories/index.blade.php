@extends('cms::layouts.admin')

@section('title', title($category ? $category->name : 'دسته‌بندی مقالات'))

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-collapse" id="navbarSupportedContent">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ 'دسته‌بندی مقالات' }}</li>
                    </ol>
                </nav>
                <div class="mx-2">
                    <a class="btn btn-primary" style="width: 90px;"
                        href="{{ route('admin.article_categories.create', $category ? $category->id : null) }}">
                        <i class="fas fa-add"></i>
                        ایجاد
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @if ($category)
        {!! renderCategoryBreadcrumb($category, 'admin.article_categories.index', 'دسته‌بندی مقالات') !!}
    @endif
    <div class="table-responsive">
        <table class="table table-hover my-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>اسلاگ</th>
                    <th>وزن</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->slug }}</td>
                        <td>{{ $c->weight }}</td>
                        <td>
                            <a class="btn btn-info"
                                href="{{ route('admin.article_categories.index', $c->id) }}">مشاهده</a>
                            <a class="btn btn-warning"
                                href="{{ route('admin.article_categories.edit', $c->id) }}">ویرایش</a>
                            <a class="btn btn-outline-danger btn-delete"
                                href="{{ route('admin.article_categories.delete', $c->id) }}">حذف</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($category)
            <a class="btn btn-outline-secondary"
                href="{{ route('admin.article_categories.index', $category->parent_id) }}">بازگشت</a>
        @endif
    </div>
@endsection
