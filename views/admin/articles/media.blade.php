@extends('cms::layouts.admin')

@section('title', title($article->title))

@section('content')
<h1 class="fw-200">{{ $article->title }}</h1>
<form method="post" action="{{ route('admin.articles.media.store', $article->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="file">انتخاب فایل</label>
                <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file[]" multiple required>
                @error('file')
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
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.articles.index') }}">بازگشت</a>
</form>
<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <th>عکس</th>
            <th>وزن</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
    @forelse($article->media as $m)
        <tr>
            <td>
                <img class="thumbnail" style="width: 200px" src="/static/media/{{ $m->file_name }}" alt="{{ $article->title }}">
            </td>
            <td>{{ $m->weight }}</td>
            <td>
                <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.articles.media.delete', [$article->id, $m->id]) }}">حذف</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
