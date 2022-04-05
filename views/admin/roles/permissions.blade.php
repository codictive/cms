@extends('cms::layouts.admin')

@section('title', title(sprintf("%s: مجوزها", $role->name)))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">نقش‌های کاربری</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
  </ol>
</nav>
<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column">
        @foreach($roles as $r)
            <li class="nav-item">
                <a class="nav-link @if($role->id == $r->id) active @endif" href="{{ route('admin.roles.permissions.show', $r->id) }}">{{ $r->name }}</a>
            </li>
        @endforeach
        </ul>
    </div>
    <div class="col-md-9">
        <form method="post" action="{{ route('admin.roles.permissions.store', $role->id) }}">
            @csrf
            <h4 class="fw-200 mt-3">API</h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>وضعیت</th>
                            <th>توضیحات</th>
                            <th>اسلاگ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $p)
                    @if(!startsWith($p->slug, 'api')) @continue @endif
                    <tr>
                        <td>
                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" @if($role->permissions->contains($p->id)) checked @endif>
                        </td>
                        <td>{{ $p->description }}</td>
                        <td class="text-right" dir="ltr">{{ $p->slug }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <h4 class="fw-200 mt-3">پنل مدیریت</h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>وضعیت</th>
                            <th>توضیحات</th>
                            <th>اسلاگ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $p)
                    @if(!startsWith($p->slug, 'admin')) @continue @endif
                    <tr>
                        <td>
                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" @if($role->permissions->contains($p->id)) checked @endif>
                        </td>
                        <td>{{ $p->description }}</td>
                        <td class="text-right" dir="ltr">{{ $p->slug }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <h4 class="fw-200 mt-3">متفرقه</h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>وضعیت</th>
                            <th>توضیحات</th>
                            <th>اسلاگ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $p)
                    @if(startsWith($p->slug, 'api') || startsWith($p->slug, 'admin')) @continue @endif
                    <tr>
                        <td>
                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" @if($role->permissions->contains($p->id)) checked @endif>
                        </td>
                        <td>{{ $p->description }}</td>
                        <td class="text-right" dir="ltr">{{ $p->slug }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.roles.index') }}">بازگشت</a>
        </form>
    </div>
</div>
@endsection
