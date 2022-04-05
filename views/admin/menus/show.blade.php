@extends('cms::layouts.admin')

@section('title', title($menu->name))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.menus.index') }}">منوها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $menu->name }}</li>
                </ol>
            </nav>
            <div class="mx-2">
                <a class="btn btn-primary" style="width: 90px;" href="{{ route('admin.menu_items.create', $menu->id) }}">
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
                <th>مسیر</th>
                <th>والد</th>
                <th>وزن</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->title }}</td>
                <td><span dir="ltr">{{ $i->path }}</span></td>
                <td>
                    @if($i->parent)
                    <span class="text-info">{{ $i->parent->title }}</span>
                    @else
                    <span class="text-muted">ندارد</span>
                    @endif
                </td>
                <td>{{ $i->weight }}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.menu_items.edit', [$menu->id, $i->id]) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.menu_items.delete', [$menu->id, $i->id]) }}">حذف</a>
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
<a class="btn btn-outline-secondary" href="{{ route('admin.menus.index') }}">بازگشت</a>
@endsection
