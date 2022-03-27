@extends('layouts.admin')
@section('title', title('کارایی'))

@php($locationsTtl = (int) kv('cache.locations.ttl'))
@php($categoriesTtl = (int) kv('cache.categories.ttl'))
@section('content')
<h1 class="fw-200">کارایی</h1>
<div class="row mt-5">
    <div class="col-6">
        <div class="card">
            <div class="card-header">دسته‌بندی</div>
            <ul class="list-group">
                <li class="list-group-item">
                    وضعیت:
                    @if(cache()->has(CACHE_KEY_CATEGORIES))
                    <span class="text-success">فعال</span>
                    @else
                    <span class="text-danger">ناموجود</span>
                    @endif
                </li>
                <li class="list-group-item">
                    طول عمر:
                    @if($categoriesTtl == 0)
                    دائمی
                    @else
                    {{ number_format($categoriesTtl) }} دقیقه
                    @endif
                </li>
                <li class="list-group-item">
                    تاریخ ایجاد:
                    @if(cache()->has(CACHE_KEY_CATEGORIES))
                    {{ g2j(unixToCarbon(getCacheAge(CACHE_KEY_CATEGORIES))) }}
                    @else
                    <span class="text-muted">نامشخص</span>
                    @endif
                </li>
                <li class="list-group-item">
                    تاریخ انقضاء:
                    @if($categoriesTtl == 0)
                    <span class="text-muted">نامشخص</span>
                    @elseif(cache()->has(CACHE_KEY_CATEGORIES))
                    {{ g2j(unixToCarbon(getCacheAge(CACHE_KEY_CATEGORIES) + ($categoriesTtl) * 60)) }}
                    @else
                    <span class="text-muted">نامشخص</span>
                    @endif
                </li>
                <div class="card-body">
                    <form class="d-inline" method="post" action="{{ route('admin.performance.cache.categories.reload') }}">
                        @csrf
                        <button class="btn btn-outline-primary" type="submit">تازه‌سازی</button>
                    </form>
                    <form class="d-inline" method="post" action="{{ route('admin.performance.cache.categories.delete') }}" id="categoriesCacheDeleteForm">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit">حذف</button>
                    </form>
                </div>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#categoriesCacheDeleteForm').on('submit', function (e) {
        if (! confirm('آیا از حذف کش دسته‌بندی اطمینان دارید؟')) {
            e.preventDefault();
        }
    });
</script>
@endsection
