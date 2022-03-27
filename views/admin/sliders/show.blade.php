@extends('layouts.admin')

@section('title', title($slider->name))

@section('content')
<h1 class="fw-200">{{ $slider->name }}</h1>
<a class="btn btn-outline-primary" href="{{ route('admin.sliders.items.create', $slider->id) }}">ایجاد اسلاید</a>
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>#</th>
                <th>کپشن</th>
                <th>مسیر</th>
                <th>وزن</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->caption }}</td>
                <td><span dir="ltr">{{ $i->link }}</span></td>
                <td>{{ $i->weight }}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.sliders.items.edit', [$slider->id, $i->id]) }}">ویرایش</a>
                    <a class="btn btn-outline-danger btn-delete" href="{{ route('admin.sliders.items.delete', [$slider->id, $i->id]) }}">حذف</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<a class="btn btn-outline-secondary" href="{{ route('admin.sliders.index') }}">بازگشت</a>
@endsection
