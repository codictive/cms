@extends('layouts.admin')
@section('title', title('درون‌ریزی CSV'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">برجسب‌ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">درون‌ریزی CSV؛ پیش‌نمایش</li>
  </ol>
</nav>

<p class="text-muted">تنها موارد جدید که در حال حاضر در دیتابیس نیست نمایش داده شده است. قبل از اجرای نهایی، از صحت اطلاعات ستون‌ها اطمینان حاصل کنید.</p>

<h4 class="m-0 mt-3 rounded-top bg-dark text-light px-3 py-2 fw-200">{{ count($result) }} برچسب</h4>
<div class="table-responsive rounded-bottom border border-top-0">
    <table class="table table-hover m-0">
        <thead>
            <tr>
                <th>نام</th>
            </tr>
        </thead>
        <tbody>
            @forelse($result as $a)
            <tr>
                <td>{{ $a['name'] }}</td>
            </tr>
            @empty
            <tr>
                <td class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<form method="post" action="{{ route('admin.tags.batch') }}">
    @csrf
    <input type="hidden" name="action" value="store_import">
    <input type="hidden" name="data" value="{{ base64_encode(json_encode($result)) }}">
    <p class="text-muted mt-3">موارد بالا در دیتابیس ایجاد شود؟</p>
    <input type="submit" class="btn btn-success" value="تائید و اجرا">
</form>
@endsection
