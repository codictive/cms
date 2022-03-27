@extends('layouts.admin')
@section('title', title('مدیریت فایل‌ها'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">فایل‌ها</li>
  </ol>
</nav>
<a class="btn btn-outline-primary" href="{{ route('admin.files.create') }}">ایجاد</a>
<div class="card shadow mt-2">
    <div class="card-body">
        <form method="get" action="{{ route('admin.files.index') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="related_type">مدل مرتبط</label>
                        <div dir="ltr" class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Codictive\Cms\Models\</span>
                            </div>
                            <input type="text" class="form-control @error('related_type') is-invalid @enderror"
                                id="related_type" name="related_type" value="{{ request()->query('related_type') }}" placeholder="Book">
                        </div>
                        @error('related_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="related_id">&nbsp;</label>
                        <input type="number" class="form-control @error('related_id') is-invalid @enderror"
                             id="related_id" name="related_id" value="{{ request()->query('related_id') }}" placeholder="شناسه">
                        @error('related_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mimetype">mimetype</label>
                        <input type="text" class="form-control @error('mimetype') is-invalid @enderror"
                            id="mimetype" name="mimetype" value="{{ request()->query('mimetype') }}" placeholder="نوع">
                        @error('mimetype')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="caption">کپشن</label>
                        <input type="text" class="form-control @error('caption') is-invalid @enderror"
                             id="caption" name="caption" value="{{ request()->query('caption') }}" placeholder="کپشن">
                        @error('caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.files.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<div class="table-responsive mt-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>کپشن</th>
                <th>نوع مدل مرتبط</th>
                <th>شناسه مدل مرتبط</th>
                <td>MimeType</td>
                <td>حجم <sub>KB</sub></td>
                <td>عملیات</td>
            </tr>
        </thead>
        <tbody>
            @forelse($files as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->caption }}</td>
                <td>{{ $f->related_type }}</td>
                <td>{{ $f->related_id }}</td>
                <td>{{ $f->mimetype }}</td>
                <td>{{ number_format($f->size / 1024) }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-info" href="{{ route('admin.files.show', $f->id) }}">جزئیات</a>
                        <a class="btn btn-warning" href="{{ route('admin.files.edit', $f->id) }}">ویرایش</a>
                        <a class="btn btn-danger btn-delete" href="{{ route('admin.files.delete', $f->id) }}">حذف</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $files->appends($_GET)->links() }}
@endsection
