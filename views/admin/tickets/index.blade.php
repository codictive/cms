@extends('cms::layouts.admin')

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
                <button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#filtersContainer" aria-expanded="false" aria-controls="filtersContainer">فیلتر و جستجو</button>
            </div>
        </div>
    </div>
</nav>
<div class="mt-2 @if(!hasFilters()) collapse @endif" id="filtersContainer">
    <div class="shadow card card-body">
        <form method="get" action="{{ route('admin.tickets.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id">شناسه</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ request()->query('id') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="user_id">شناسه کاربر مربوطه</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ request()->query('user_id') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="subject">موضوع</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ request()->query('subject') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="priority">فوریت</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="">-- مهم نیست --</option>
                            @foreach ($priority as $p)
                            <option value="{{ $p }}" @if(request()->query('priority') == $p) selected @endif>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="department">دپارتمان</label>
                        <select class="form-control" id="department" name="department">
                            <option value="">-- مهم نیست --</option>
                            @foreach ($departments as $d)
                            <option value="{{ $d }}" @if(request()->query('department') == $d) selected @endif>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- مهم نیست --</option>
                            @foreach ($status as $s)
                            <option value="{{ $s }}" @if(request()->query('status') == $s) selected @endif>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="order_by">مرتب‌سازی بر اساس</label>
                        <select class="form-control" id="order_by" name="order_by">
                            <option value="id" @if(request()->query('order_by') == 'id') selected @endif>شناسه</option>
                            <option value="subject" @if(request()->query('order_by') == 'subject') selected @endif>موضوع</option>
                            <option value="user_id" @if(request()->query('order_by') == 'user_id') selected @endif>شناسه کاربر</option>
                            <option value="status" @if(request()->query('order_by') == 'status') selected @endif>وضعیت</option>
                            <option value="priotiry" @if(request()->query('order_by') == 'priotiry') selected @endif>فوریت</option>
                            <option value="created_at" @if(request()->query('order_by') == 'created_at') selected @endif>تاریخ ثبت</option>
                            <option value="updated_at" @if(request()->query('order_by') == 'updated_at') selected @endif>تاریخ به‌روز رسانی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="order_dir">در جهت</label>
                        <select class="form-control" id="order_dir" name="order_dir">
                            <option value="DESC" @if(request()->query('order_dir') == 'DESC') selected @endif>نزولی</option>
                            <option value="ASC" @if(request()->query('order_dir') == 'ASC') selected @endif>صعودی</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="per_page">تعداد تیکت در هر صفحه</label>
                        <input type="number" class="form-control" id="per_page" name="per_page" value="{{ request()->query('per_page') ?: 30 }}">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.tickets.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<form method="post" action="{{ route('admin.tickets.batch') }}" id="batch-form">
@csrf
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                 <th>
                    <input type="checkbox" id="checkAll">
                </th>
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
                <td><input type="checkbox" name="batch[]" value="{{ $i->id }}"></td>
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
<div class="clearfix">
    <div class="w-25 float-left">
        <div class="form-group">
            <select class="form-control" name="action" id="action">
                <option value="" selected>عملیات گروهی</option>
                <option value="status">وضعیت</option>
                <option value="delete">حذف</option>
            </select>
        </div>
    </div>
    <div class="float-right">
        {{ $tickets->appends($_GET)->links() }}
    </div>
</div>
</form>
@endsection
