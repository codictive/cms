@extends('cms::layouts.admin')

@section('title', title('برچسب‌ها'))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item active" aria-current="page">برچسب‌ها</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.tags.create') }}">
                    <i class="fas fa-add"></i>
                    ایجاد
                </a>
            </div>
        </div>
    </div>
</nav>
<form method="post" action="{{ route('admin.tags.batch') }}" id="batch-form">
    @csrf
    <div class="table-responsive">
        <table class="table table-hover my-4">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>#</th>
                    <th>نام</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $t)
                <tr>
                    <td><input type="checkbox" name="batch[]" value="{{ $t->id }}"></td>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->name }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-warning" href="{{ route('admin.tags.edit', $t->id) }}">ویرایش</a>
                            <a class="btn btn-danger btn-delete" href="{{ route('admin.tags.delete', $t->id) }}">حذف</a>
                        </div>
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
    <div class="clearfix">
        <div class="w-25 float-left">
            <div class="form-group">
                <select class="form-control" name="action" id="action">
                    <option value="" selected>عملیات گروهی</option>
                    <option value="import">درون‌ریزی CSV</option>
                    <option value="delete">حذف</option>
                </select>
            </div>
        </div>
        <div class="float-right">
            {{ $tags->links() }}
        </div>
    </div>
</form>
@endsection
