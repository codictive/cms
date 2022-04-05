@extends('cms::layouts.admin')

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
                <button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#filtersContainer" aria-expanded="false" aria-controls="filtersContainer">فیلتر و جستجو</button>
            </div>
        </div>
    </div>
</nav>
<div class="mt-2 @if(!hasFilters()) collapse @endif" id="filtersContainer">
    <div class="shadow card card-body">
        <form method="get" action="{{ route('admin.articles.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id">شناسه</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ request()->query('id') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ request()->query('title') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- مهم نیست --</option>
                            <option value="published" @if(request()->query('status') == 'published') selected @endif>منتشر شده</option>
                            <option value="unpublished" @if(request()->query('status') == 'unpublished') selected @endif>منتشر نشده</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_by">مرتب‌سازی بر اساس</label>
                        <select class="form-control" id="order_by" name="order_by">
                            <option value="id" @if(request()->query('order_by') == 'id') selected @endif>شناسه</option>
                            <option value="title" @if(request()->query('order_by') == 'title') selected @endif>عنوان</option>
                            <option value="published" @if(request()->query('order_by') == 'published') selected @endif>وضعیت</option>
                            <option value="created_at" @if(request()->query('order_by') == 'created_at') selected @endif>تاریخ ثبت</option>
                            <option value="updated_at" @if(request()->query('order_by') == 'updated_at') selected @endif>تاریخ به‌روز رسانی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_dir">در جهت</label>
                        <select class="form-control" id="order_dir" name="order_dir">
                            <option value="DESC" @if(request()->query('order_dir') == 'DESC') selected @endif>نزولی</option>
                            <option value="ASC" @if(request()->query('order_dir') == 'ASC') selected @endif>صعودی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="per_page">تعداد مقاله در هر صفحه</label>
                        <input type="number" class="form-control" id="per_page" name="per_page" value="{{ request()->query('per_page') ?: 30 }}">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.articles.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<form method="post" action="{{ route('admin.articles.batch') }}" id="batch-form">
@csrf
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="checkAll">
                </th>
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
                <td><input type="checkbox" name="batch[]" value="{{ $a->id }}"></td>
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
<div class="clearfix">
    <div class="w-25 float-left">
        <div class="form-group">
            <select class="form-control" name="action" id="action">
                <option value="" selected>عملیات گروهی</option>
                <option value="import">درون‌ریزی CSV</option>
                <option value="category">دسته‌بندی</option>
                <option value="published">وضعیت انتشار</option>
                <option value="delete">حذف</option>
            </select>
        </div>
    </div>
    <div class="float-right">
        {{ $articles->appends($_GET)->links() }}
    </div>
</div>
</form>
@endsection
