@extends('cms::layouts.admin')

@section('title', title('عملیات گروهی'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">مقالات</a></li>
    <li class="breadcrumb-item active" aria-current="page">عملیات گروهی</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.articles.batch') }}">
    @csrf
    <div class="row">
        @if($action == 'published')
        <div class="col-12">
            <div class="mb-3 form-check">
                @foreach ($articleIds as $id)
                <input type="hidden" name="batch[]" value="{{ $id }}">
                @endforeach
                <input type="hidden" name="action" value="store_publishe">
                <label for="active">وضعیت انتشار</label>
                <div class="checkbox">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="custom-control-input" id="published" name="published" checked>
                        <label for="published" class="custom-control-label mt-1">
                            <span class="pr-4">صفحه منتشر شود</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @elseif($action == 'category')
        <div class="col-md-12">
            <div class="form-group">
                @foreach ($articleIds as $id)
                <input type="hidden" name="batch[]" value="{{ $id }}">
                @endforeach
                <input type="hidden" name="action" value="store_category">
                <label>دسته بندی</label>
                <select class="form-control" name="category">
                    <option value="">انتخاب کنید</option>
                    @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        @endif
        <div class="col-12">
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.articles.index') }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection
