@extends('cms::layouts.admin')

@section('title', title($ticket->subject))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">تیکت‌ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $ticket->subject }}</li>
                </ol>
            </nav>
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
<h1 class="fw-200">{{ $ticket->subject }}</h1>
<form action="{{ route('admin.tickets.conversations.store', $ticket->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="body">متن</label>
        <textarea rows="5" type="text" class="form-control @error('body') is-invalid @enderror" id="body" name="body" value="{{ old('body') }}" ></textarea>
        @error('body')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="file">فایل</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" value="{{ old('file') }}">
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.tickets.index') }}">بازگشت</a>
</form>
<hr>
@forelse ($conversation as $c)
<div class="row mt-3">
    <div class="col-md-6 @if($c->sender_id == $ticket->user_id) offset-md-6 @endif">
        <div class="card">
            <div class="card-header">
                {{ $c->sender->name }}
                <br>
                <small class="text-muted">{{ g2j($c->created_at) }}</small>
            </div>
            <div class="card-body">
                @if($c->type == 'text')
                {!! nl2br($c->body) !!}
                @endif
                <div>
                    @if($c->type == 'text')
                    <a class="btn btn-warning" href="{{ route('admin.tickets.conversations.edit', [$ticket->id, $c->id]) }}">ویرایش</a>
                    @else
                    <a class="btn btn-info" href="/static/files/{{ $c->file->filename }}">مشاهده فایل</a>
                    @endif
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.tickets.conversations.delete', [$ticket->id, $c->id]) }}">حذف</a>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<p class="text-muted">موردی برای نمایش وجود ندارد.</p>
@endforelse


{{ $conversation->links() }}
@endsection
