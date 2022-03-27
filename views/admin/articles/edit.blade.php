@extends('layouts.admin')

@section('title', title($article->title))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">مقالات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<form method="post" class="mt-2" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title">عنوان</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title', $article->title) }}" required autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="slug">اسلاگ</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    value="{{ old('slug', $article->slug) }}" required>
                @error('slug')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="headline">سرتیتر</label>
                <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline"
                    name="headline" value="{{ old('headline', $article->headline) }}">
                @error('headline')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image">تصویر اصلی</label>
                @if($article->image)
                <small class="form-text text-muted">تنها جهت تغییر تصویر فعلی، تصویر جدیدی انتخاب کنید.</small>
                <div>
                    <img class="img-thumbnail" style="width: 300px;"
                        src="{{ getThumbnail('articles', $article->image, '400x_') }}" alt="{{ $article->title }}">
                </div>
                @endif
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                    name="image">
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="summary">خلاصه</label>
                <textarea rows="3" class="form-control @error('summary') is-invalid @enderror" id="summary"
                    name="summary">{{ old('summary', $article->summary) }}</textarea>
                @error('summary')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body">متن کامل</label>
                <textarea rows="6" class="form-control @error('body') is-invalid @enderror" id="body" name="body"
                    required>{{ old('body', $article->body) }}</textarea>
                @error('body')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
           <div class="mb-3">
                    <label>دسته‌بندی</label>
                    <select class="form-control" name="category_id">
                        <option value="">-- انتخاب کنید --</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if( old('category_id', $article->article_category_id) == $c->id) selected @endif >{{ $c->name }}</option>
                        @endforeach
                    </select>
            </div>
            <div class="mb-3">
                <label for="tags">برچسب‌ها</label>
                <textarea rows="6" class="form-control @error('tags') is-invalid @enderror" id="tags"
                    name="tags">{{ old('tags', implode("\n", $article->tags->map(function($t){return $t->name;})->all())) }}</textarea>
                @error('tags')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="meta_keywords">کلیدواژه‌های متا</label>
                <textarea rows="6" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords"
                    name="meta_keywords">{{ old('meta_keywords', $article->meta_keywords) }}</textarea>
                @error('meta_keywords')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="meta_description">توضیحات متا</label>
                <textarea rows="6" class="form-control @error('meta_description') is-invalid @enderror"
                    id="meta_description"
                    name="meta_description">{{ old('meta_description', $article->meta_description) }}</textarea>
                @error('meta_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <div class="checkbox">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="custom-control-input" id="published" name="published" @if(old('published', $article->published)) checked @endif>
                        <label for="published" class="custom-control-label mt-1">
                            <span class="pr-4">صفحه منتشر شود</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3 form-check">
                <div class="checkbox">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="custom-control-input" id="promote_to_homepage" name="promote_to_homepage" @if(old('promote_to_homepage', $article->promote_to_homepage)) checked @endif>
                        <label for="promote_to_homepage" class="custom-control-label mt-1">
                            <span class="pr-4">نمایش در صفحه اصلی سایت</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3 form-check">
                <div class="checkbox">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="custom-control-input" id="stick_to_top" name="stick_to_top" @if(old('stick_to_top', $article->stick_to_top)) checked @endif>
                        <label for="stick_to_top" class="custom-control-label mt-1">
                            <span class="pr-4">نمایش در ابتدای فهرست</span>
                        </label>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.articles.index') }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="/lib/ckeditor/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        CKEDITOR.replace('body', {
            language: "fa"
        });
    });

</script>
@endsection
