@extends('cms::layouts.admin')

@section('title', title($feedback->subject))

@section('content')
<h1 class="fw-200">{{ $feedback->subject }}</h1>
<div class="my-3">
    <p>
        {!! nl2br($feedback->body) !!}
    </p>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <tbody>
            <tr>
                <th>نام نویسنده</th>
                <td>{{ $feedback->author_name }}</td>
            </tr>
            <tr>
                <th>موبایل نویسنده</th>
                <td><a href="tel:{{ $feedback->author_mobile }}">{{ $feedback->author_mobile }}</a></td>
            </tr>
            <tr>
                <th>دپارتمان</th>
                <td>{{ $feedback->department }}</td>
            </tr>
            <tr>
                <th>تاریخ ثبت</th>
                <td>{{ g2j($feedback->created_at) }}</td>
            </tr>
        </tbody>
    </table>
</div>
<a class="btn btn-outline-secondary" href="{{ route('admin.feedback.index') }}">بازگشت</a>
@endsection
