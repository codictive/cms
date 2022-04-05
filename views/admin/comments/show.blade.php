@extends('cms::layouts.admin')

@section('title', title($comment->user->name ?? $comment->author_name))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">دیدگاه‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $comment->user->name ?? $comment->author_name }}</li>
  </ol>
</nav>
<div class="row">
    <div class="col-md-6">
        <div class="table-responsive mb-3">
            <table class="table table-hover">
                <tbody>
                    @if ($comment->parent)
                        <tr>
                            <th>شناسه والد</th>
                            <td>{{ $comment->parent_id }}</td>
                        </tr>
                        <tr>
                            <th>متن دیدگاه والد</th>
                            <td>{{ $comment->body }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>مدل مرتبط</th>
                        <td>
                            @if ($comment->related_type == 'Codictive\Cms\Models\Book')
                                <a href="{{ route('admin.books.show', $comment->related->id) }}">{{ $comment->related->title }}</a>
                            @elseif($comment->related_type == 'Codictive\Cms\Models\Author')
                                <a href="{{ route('admin.books.show', $comment->related->id) }}">{{ $comment->related->name }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>شناسه مربوطه</th>
                        <td>{{ $comment->related_id }}</td>
                    </tr>
                    <tr>
                        <th>موافق</th>
                        <td>{{ $comment->likes }}</td>
                    </tr>
                    <tr>
                        <th>مخالف</th>
                        <td>{{ $comment->dislikes }}</td>
                    </tr>
                    <tr>
                        <th>وضعیت</th>
                        <td>
                            @if ($comment->is_approved)
                            تایید شده
                            @else
                            تایید نشده
                            @endif
                            <span class="float-right">
                            <a class="btn-sm btn-success" href="{{ route('admin.comments.approved', ['is_approved' => 'true' ,$comment->id]) }}">تایید</a>
                            <a class="btn-sm btn-danger" href="{{ route('admin.comments.approved', ['is_approved' => 'false' ,$comment->id]) }}">رد</a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>متن دیدگاه</th>
                        <td>{{ $comment->body }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if (count($replayComments))
        <h3>پاسخ‌ها</h3>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>نام و نام‌خانوادگی</th>
                        <th>متن دیدگاه</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($replayComments as $c)
                    <tr>
                        <th>@if($c->user_id)<a href="{{ route('admin.users.show', $c->user->id) }}">{{ $c->user->name }}</a>@else{{ $c->author_name }}@endif</th>
                        <td>{{ $c->body }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="col-md-6">
        <form method="post" action="{{ route('admin.comments.store_replay', $comment->id) }}">
            @csrf
            <div class="form-group">
                <label for="body">متن پاسخ</label>
                <textarea rows="5" class="form-control @error('body') is-invalid @enderror" id="body" name="body" required>{{ old('body') }}</textarea>
                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.comments.index') }}">بازگشت</a>
        </form>
    </div>
</div>
@endsection
