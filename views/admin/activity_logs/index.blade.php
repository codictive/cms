@extends('cms::layouts.admin')
@section('title', title('لاگ فعالیت'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">لاگ فعالیت کاربران</li>
  </ol>
</nav>
<div class="card shadow">
    <div class="card-body">
        <form method="get" action="{{ route('admin.activity_logs.index') }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user_id">شناسه کاربر</label>
                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ request()->query('user_id') }}">
                        @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="related_type">مدل مرتبط</label>
                        <div dir="ltr" class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Codictive\Cms\Models\</span>
                            </div>
                            <input type="text" class="form-control @error('related_type') is-invalid @enderror" id="related_type" name="related_type" value="{{ request()->query('related_type') }}" placeholder="Book">
                        </div>
                        @error('related_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="related_id">&nbsp;</label>
                        <input type="number" class="form-control @error('related_id') is-invalid @enderror" id="related_id" name="related_id" value="{{ request()->query('related_id') }}" placeholder="شناسه">
                        @error('related_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="action">عملیات</label>
                        <select class="form-control @error('action') is-invalid @enderror" id="action" name="action">
                            <option value="">-- همه --</option>
                            @foreach($actions as $a)
                            <option value="{{ $a }}" @if(request()->query('action') == $a) selected @endif>{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('action')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="query">عبارت جستجو</label>
                        <input type="text" class="form-control @error('query') is-invalid @enderror" id="query" name="query" value="{{ request()->query('query') }}">
                        @error('query')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.activity_logs.index') }}">حذف فیلتر</a>
            @endif
        </form>
    </div>
</div>
<div class="table-responsive mt-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>کاربر</th>
                <th>مدل</th>
                <th>عملیات</th>
                <th>تاریخ</th>
                <th>جزئیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $l)
            <tr>
                <td>
                    @if($l->user)
                    {{ $l->user->id }}:
                    <a href="{{ route('admin.users.show', $l->user->id) }}">{{ $l->user->name }}</a>
                    @else
                    <span class="text-muted">نامشخص</span>
                    @endif
                </td>
                <td class="text-right">{{ $l->related_type }}: {{ $l->related_id }}</td>
                <td>{{ $l->action }}</td>
                <td>{{ g2j($l->created_at) }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.activity_logs.show', $l->id) }}">جزئیات</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $logs->appends($_GET)->links() }}
@endsection
