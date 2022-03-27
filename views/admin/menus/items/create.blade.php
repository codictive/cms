@extends('layouts.admin')

@section('title', title("ایجاد آیتم در {$menu->name}"))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.menus.show', $menu->id) }}">آیتم‌های منو {{ $menu->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ایجاد آیتم در {{ $menu->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<form method="post" class="mt-2" action="{{ route('admin.menu_items.store', $menu->id) }}">
    @csrf
    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title">عنوان</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="path">مسیر</label>
                <input dir="ltr" type="text" class="form-control @error('path') is-invalid @enderror" id="path" name="path" value="{{ old('path') }}" required>
                @error('path')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="parent_id">والد</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id" value="{{ old('parent_id') }}">
                    <option value="">-- انتخاب کنید --</option>
                    @foreach($items as $i)
                    <option value="{{ $i->id }}">{{ $i->title }}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="weight">وزن</label>
                <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', '0') }}" required>
                @error('weight')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.menus.show', $menu->id) }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection
