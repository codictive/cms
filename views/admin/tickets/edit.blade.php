@extends('layouts.admin')

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
        </div>
    </div>
</nav>
<form method="post" class="mt-2" action="{{ route('admin.tickets.update', $ticket->id) }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="user_id">شناسه کاربر</label>
                <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id', $ticket->user_id) }}" required>
                @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="subject">موضوع</label>
                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $ticket->subject) }}" required>
                @error('subject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="department">دپارتمان</label>
                <select name="department" class="form-control @error('department') is-invalid @enderror" id="department">
                    @foreach ($departments as $d)
                        <option value="{{ $d }}" @if(old('department', $ticket->department) == $d) selected @endif>{{ $d }}</option>
                    @endforeach
                </select>
                @error('department')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="priority">اولویت</label>
                <select name="priority" class="form-control @error('priority') is-invalid @enderror" id="priority">
                    @foreach ($priority as $p)
                        <option value="{{ $p }}" @if(old('priority', $ticket->priority) == $p) selected @endif>{{ $p }}</option>
                    @endforeach
                </select>
                @error('priority')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status">وضعیت</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                    @foreach ($status as $s)
                        <option value="{{ $s }}" @if(old('status', $ticket->status) == $s) selected @endif>{{ $s }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
        <div class="col-md-6">
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.tickets.index') }}">بازگشت</a>
        </div>
</form>
@endsection
