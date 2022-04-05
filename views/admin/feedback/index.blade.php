@extends('cms::layouts.admin')

@section('title', title('مدیریت بازخوردها'))

@section('content')
<h1 class="fw-200">مدیریت بازخوردها</h1>
<div class="table-responsive">
    <table class="table table-hover my-4">
        <thead>
            <tr>
                <th>#</th>
                <th>نویسنده</th>
                <th>موضوع</th>
                <th>دپارتمان</th>
                <th>تاریخ ثبت</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->author_name }}</td>
                <td>{{ $f->subject }}</td>
                <td>{{ $f->department }}</td>
                <td>{{ g2j($f->created_at) }}</td>
                <td>
                    @if($f->seen)
                    <span class="text-success">خوانده شده</span>
                    @else
                    <span class="text-danger">خوانده نشده</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{route('admin.feedback.show', $f->id)}}">مشاهده</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-muted">موردی جهت نمایش وجود ندارد.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $feedbacks->links() }}
@endsection
