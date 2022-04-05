@extends('cms::layouts.admin')

@section('title', title($conversation->ticket->user->name))

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.conversations.index') }}">گفتگوها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $conversation->ticket->user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</nav>
<form method="post" action="{{ route('admin.tickets.conversations.update', [$ticket->id, $conversation->id]) }}">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="body">توضیحات</label>
                <textarea rows="5" class="form-control @error('body') is-invalid @enderror" id="body" name="body" required>{{ old('body', $conversation->body) }}</textarea>
                @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.tickets.conversations.index', $ticket->id) }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection
