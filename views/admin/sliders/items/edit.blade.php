@extends('cms::layouts.admin')

@section('title', title($slider->name))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.show', $slider->id) }}">آیتم‌های اسلایدر</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $slider->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<form method="post" class="mt-2" action="{{ route('admin.sliders.items.update', [$slider->id, $item->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="caption">کپشن</label>
                <input type="text" class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" value="{{ old('caption', $item->caption) }}" autofocus>
                @error('caption')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="link">لینک</label>
                <input dir="ltr" type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $item->link) }}">
                @error('link')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="image">تصویر اسلاید</label>
                @if($item->image)
                <small class="form-text text-muted">تنها جهت تغییر تصویر فعلی، تصویر جدیدی انتخاب کنید.</small>
                <div>
                    <img class="img-thumbnail" style="width: 300px;" src="/static/slider/{{ $item->image }}" alt="{{ $item->caption }}">
                </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="weight">وزن</label>
                <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $item->weight) }}" required>
                @error('weight')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.sliders.show', $slider->id) }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection
