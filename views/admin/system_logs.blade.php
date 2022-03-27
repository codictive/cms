@extends('layouts.admin')

@section('title', title('لاگ سیستم'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item active" aria-current="page">لاگ سیستم</li>
  </ol>
</nav>
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="get" action="{{ route('admin.system_logs.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="level">سطح</label>
                        <select class="form-control" id="level" name="level">
                            <option value="">-- همه --</option>
                            <option value="FATAL" @if(request()->query('level') == 'FATAL') selected @endif>خطای مرگ‌بار</option>
                            <option value="ERROR" @if(request()->query('level') == 'ERROR') selected @endif>خطا</option>
                            <option value="WARNING" @if(request()->query('level') == 'WARNING') selected @endif>هشدار</option>
                            <option value="DEBUG" @if(request()->query('level') == 'DEBUG') selected @endif>عیب‌یابی</option>
                            <option value="INFO" @if(request()->query('level') == 'INFO') selected @endif>اطلاعات</option>
                            <option value="SUCCESS" @if(request()->query('level') == 'SUCCESS') selected @endif>موفق</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="context">زمینه</label>
                        <input type="text" class="form-control" id="context" name="context" value="{{ request()->query('context') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="path">مسیر</label>
                        <input type="text" class="form-control" id="path" name="path" value="{{ request()->query('path') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message">پیام</label>
                        <input type="text" class="form-control" id="message" name="message" value="{{ request()->query('message') }}">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-success" value="بگرد">
            @if(hasFilters())
            <a class="btn btn-outline-warning mx-2" href="{{ route('admin.system_logs.index') }}">حذف فیلتر</a>
            @endif
            <a class="btn btn-outline-danger btn-delete mx-2" href="{{ route('admin.system_logs.truncate') }}">حذف لاگ‌ها</a>
        </form>
    </div>
</div>
@forelse($logs as $l)
<div class="mt-1">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td @switch($l->level)
                @case('FATAL') @case('ERROR') class=" text-center text-danger" @break
                @case('WARNING') class=" text-center text-warning" @break
                @case('INFO') class=" text-center text-info" @break
                @case('SUCCESS') class=" text-center text-success" @break
                @endswitch>{{ $l->level }}</td>
                <td @switch($l->level)
                @case('FATAL') @case('ERROR') class=" text-right" @break
                @case('WARNING') class=" text-right" @break
                @case('INFO') class=" text-right" @break
                @case('SUCCESS') class=" text-right" @break
                @endswitch dir="ltr">{{ $l->context }}</td>
                <td @switch($l->level)
                @case('FATAL') @case('ERROR') class=" text-right" @break
                @case('WARNING') class=" text-right" @break
                @case('INFO') class=" text-right" @break
                @case('SUCCESS') class=" text-right" @break
                @endswitch dir="ltr">{{ $l->path }}</td>
                <td @switch($l->level)
                @case('FATAL') @case('ERROR') class=" text-center" @break
                @case('WARNING') class=" text-center" @break
                @case('INFO') class=" text-center" @break
                @case('SUCCESS') class=" text-center" @break
                @endswitch>{{ g2j($l->created_at) }}</td>
            </tr>
            <tr>
                <td @switch($l->level)
                @case('FATAL') @case('ERROR') style="border-bottom: 3px solid #dc3545;" @break
                @case('WARNING') style="border-bottom: 3px solid #ffc107;" @break
                @case('INFO') style="border-bottom: 3px solid #17a2b8;" @break
                @case('SUCCESS') style="border-bottom: 3px solid #28a745;" @break
                @default style="border-bottom-width: 3px;" @break
                @endswitch class="text-right" colspan="4" dir="ltr">
                    <div class="w-100 overflow-auto" style="word-break: break-word; max-height: 40vh;">
                        {!! nl2br($l->message) !!}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@empty
<p class="text-center text-muted mt-3">موردی جهت نمایش وجود ندارد.</p>
@endforelse
{{ $logs->appends($_GET)->links() }}
@endsection
