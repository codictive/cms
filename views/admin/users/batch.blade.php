@extends('cms::layouts.admin')

@section('title', title('عملیات گروهی'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
    <li class="breadcrumb-item active" aria-current="page">عملیات گروهی</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.users.batch') }}">
    @csrf
    @if($action == 'roles')
    <div class="form-group">
        @foreach ($userIds as $id)
        <input type="hidden" name="batch[]" value="{{ $id }}">
        @endforeach
        <input type="hidden" name="action" value="store_roles">
        <label>نقش‌ها</label>
        @forelse($roles as $role)
        <div class="form-check">
            <label>
                <input type="checkbox" class="form-check-input" name="roles[]" value="{{$role->id}}">
                {{ $role->name }}
            </label>
        </div>
        @empty
        <p class="text-muted">موردی جهت نمایش وجود ندارد.</p>
        @endforelse
    </div>
    @elseif($action == 'verified')
    <div class="col-md-12">
        <div class="form-group">
            @foreach ($userIds as $id)
            <input type="hidden" name="batch[]" value="{{ $id }}">
            @endforeach
            <input type="hidden" name="action" value="store_verified">
            <label>وضعیت</label>
            <div class="form-check">
                <label>
                    <input type="checkbox" class="form-check-input" name="is_verified" id="is_verified">
                    کاربر احراز هویت شده است.
                </label>
            </div>
        </div>
    </div>
    @elseif($action == 'active')
     <div class="col-md-12">
        <div class="form-group">
            @foreach ($userIds as $id)
            <input type="hidden" name="batch[]" value="{{ $id }}">
            @endforeach
            <input type="hidden" name="action" value="store_active">
            <label>وضعیت</label>
            <div class="form-check">
            <label>
                <input type="checkbox" class="form-check-input" name="is_active" id="is_active">
                کاربر فعال است.
            </label>
        </div>
        </div>
    </div>
    @endif
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{route('admin.users.index')}}">بازگشت</a>
</form>
@endsection
