@extends('layouts.admin')
@section('title', title('درون‌ریزی CSV'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">برچسب‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">درون‌ریزی CSV</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.tags.batch') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="action" value="preview_import">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="required" for="file">فایل CSV</label>
                <input type="file" accept="text/csv" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" required>
                @error('file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="skip_header">سرتیتر</label>
                <div class="form-check">
                    <label>
                        <input type="checkbox" class="form-check-input" id="skip_header" name="skip_header">
                        از سطر اول فایل چشم‌پوشی کن.
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p class="text-muted">شماره ستون هر یک از فیلدها را مشخص کنید. فیلدهایی که مقدار ندارند را خالی بگذارید.</p>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="required" for="name">نام</label>
                <input type="number" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', '1') }}" required>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="بررسی">
</form>
@endsection
