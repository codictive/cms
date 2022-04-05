@extends('cms::layouts.admin')

@section('title', title($comment->user->name))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">دیدگاه‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $comment->user->name ?? $comment->author_name }}</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.comments.update', $comment->id) }}">
    @csrf
    <div class="form-group">
        <label for="body">متن دیدگاه</label>
        <textarea rows="5" class="form-control @error('body') is-invalid @enderror" id="body" name="body" required>{{ old('body', $comment->body) }}</textarea>
        @error('body')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group form-check">
        <div class="checkbox">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" @if($comment->is_approved) checked @endif>
                <label for="is_approved" class="custom-control-label mt-1">
                    <span class="pr-4">تایید شده/ نشده</span>
                </label>
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.comments.index') }}">بازگشت</a>
</form>
@endsection
