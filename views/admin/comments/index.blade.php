@extends('cms::layouts.admin')

@section('title', title('دیدگاه‌ها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مدیریت دیدگاه‌ها</li>
                </ol>
            </nav>
            <button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#filtersContainer" aria-expanded="false" aria-controls="filtersContainer">فیلتر و جستجو</button>
        </div>
    </div>
</nav>
<div class="mt-2 @if(!hasFilters()) collapse @endif" id="filtersContainer">
    <div class="shadow card card-body">
        <form method="get" action="{{ route('admin.comments.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id">شناسه</label>
                        <input type="number" class="form-control" id="id" name="id" value="{{ request()->query('id') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user_id">شناسه کاربر</label>
                        <input type="number" class="form-control" id="user_id" name="user_id" value="{{ request()->query('user_id') }}">
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label for="related_id">شناسه مربوطه</label>
                        <input type="number" class="form-control" id="related_id" name="related_id" value="{{ request()->query('related_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="related_type">مدل مرتبط</label>
                        <div dir="ltr" class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Codictive\Cms\Models\</span>
                            </div>
                            <input type="text" class="form-control" id="related_type" name="related_type"
                                value="{{ request()->query('related_type') }}" placeholder="Book">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_approved">وضعیت</label>
                        <select class="form-control @error('is_approved') is-invalid @enderror" name="is_approved" id="is_approved">
                            <option value="">-- انتخاب کنید --</option>
                            <option value="true" @if(request()->query('is_approved') == 'true') selected @endif>تایید شده</option>
                            <option value="false" @if(request()->query('is_approved') == 'false') selected @endif>تایید نشده</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_by">مرتب‌سازی بر اساس</label>
                        <select class="form-control" id="order_by" name="order_by">
                            <option value="id" @if(request()->query('order_by') == 'id') selected @endif>شناسه</option>
                            <option value="user_id" @if(request()->query('order_by') == 'user_id') selected @endif>شناسه کاربر</option>
                            <option value="related_type" @if(request()->query('order_by') == 'related_type') selected @endif>نوع</option>
                            <option value="created_at" @if(request()->query('order_by') == 'created_at') selected @endif>تاریخ ثبت</option>
                            <option value="updated_at" @if(request()->query('order_by') == 'updated_at') selected @endif>تاریخ بروزرسانی</option>
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
                        <label for="per_page">تعداد دیدگاه در هر صفحه</label>
                        <input type="number" class="form-control" id="per_page" name="per_page" value="{{ request()->query('per_page') ?: 30 }}">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.comments.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>#</th>
                <th>نام‌ و ‌نام‌خانوادگی</th>
                <th>مدل مرتبط</th>
                <th>شناسه مربوطه</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>
                    <a @if($t->user_id) href="{{ route('admin.users.show', $t->user_id) }}" @endif> {{ $t->user->name ?? $t->author_name }}</a>
                </td>
                <td>
                    @if ($t->related_type == 'Codictive\Cms\Models\Product')
                        <a href="{{ route('admin.books.show', $t->related->id) }}">{{ $t->related->title ?? '' }}</a>
                    @else
                    <p>نامشخص</p>
                    @endif
                </td>
                <td>{{ $t->related_id }}</td>
                <td>
                    @if ($t->is_approved)
                    تایید شده
                    @else
                    تایید نشده
                    @endif
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        {{-- <a class="btn btn-primary" href="{{ route('admin.comments.show', $t->id) }}">مشاهده</a> --}}
                        <a class="btn btn-warning" href="{{ route('admin.comments.edit', $t->id) }}">ویرایش</a>
                        <a class="btn btn-danger btn-delete" href="{{ route('admin.comments.delete', $t->id) }}">حذف</a>
                    </div>
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
{{ $comments->appends($_GET)->links() }}
@endsection
