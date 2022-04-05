@extends('cms::layouts.admin')

@section('title', title('مدیریت مجوزهای دسترسی'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">مجوزهای دسترسی</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.permissions.store') }}">
    @csrf
    <h4 class="fw-200 mt-3">API</h4>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>مجوز</th>
                    @foreach ($roles as $role)
                    <th>{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $perm)
                @if(!startsWith($perm->slug, 'api')) @continue @endif
                <tr>
                    <td>{{ $perm->description }} <span class="small text-muted">{{ $perm->slug }}</span></td>
                    @foreach ($roles as $role)
                    <td><input type="checkbox" name="{{$perm->id}},{{$role->id}}" @if($role->permissions->contains($perm->id)) checked @endif></td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($roles) + 1 }}" class="text-info">موردی جهت نمایش وجود ندارد.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <h4 class="fw-200 mt-5">پنل مدیریت</h4>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>مجوز</th>
                    @foreach ($roles as $role)
                    <th>{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $perm)
                @if(!startsWith($perm->slug, 'admin')) @continue @endif
                <tr>
                    <td>{{ $perm->description }} <span class="small text-muted">{{ $perm->slug }}</span></td>
                    @foreach ($roles as $role)
                    <td><input type="checkbox" name="{{$perm->id}},{{$role->id}}" @if($role->permissions->contains($perm->id)) checked @endif></td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($roles) + 1 }}" class="text-info">موردی جهت نمایش وجود ندارد.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <h4 class="fw-200 mt-5">متفرقه</h4>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>مجوز</th>
                    @foreach ($roles as $role)
                    <th>{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $perm)
                @if(startsWith($perm->slug, 'api') || startsWith($perm->slug, 'admin')) @continue @endif
                <tr>
                    <td>{{ $perm->description }} <span class="small text-muted">{{ $perm->slug }}</span></td>
                    @foreach ($roles as $role)
                    <td><input type="checkbox" name="{{$perm->id}},{{$role->id}}" @if($role->permissions->contains($perm->id)) checked @endif></td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($roles) + 1 }}" class="text-info">موردی جهت نمایش وجود ندارد.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
</form>
@endsection
