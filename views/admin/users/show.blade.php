@extends('layouts.admin')

@section('title', title($user->name))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">کاربران</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
  </ol>
</nav>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">مشخصات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#books" role="tab">کتاب‌ها</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#comments" role="tab">دیدگاه‌ها</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#quotes" role="tab">نقل‌قول‌ها</a>
    </li>
</ul>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>شناسه</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>نام</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>موبایل</th>
                        <td>{{ $user->mobile }}</td>
                    </tr>
                    <tr>
                        <th>ایمیل</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>نقش‌ها</th>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }} <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>وضعیت</th>
                        <td>
                            @if($user->is_active)
                            <span class="text-success">فعال است</span>
                            @else
                            <span class="text-danger">غیر فعال است</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>احراز هویت</th>
                        <td>
                            @if($user->is_verified)
                            <span class="text-success">احراز شده است</span>
                            @else
                            <span class="text-danger">احراز نشده است</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>تاریخ ایجاد</th>
                        <td>{{ g2j($user->created_at) }}</td>
                    </tr>
                    <tr>
                        <th>تاریخ آخرین به‌روز رسانی</th>
                        <td>{{ g2j($user->updated_at) }}</td>
                    </tr>
                    @if ($user->deleted_at)
                    <tr>
                        <th>تاریخ حذف</th>
                        <td>{{ g2j($user->deleted_at) }}</td>
                    </tr>
                    @endif
                    @if ($user->image)
                    <tr>
                        <th>تصویر</th>
                        <td>
                            <div class=" w-25">
                                <div class="ratio ratio-1x1">
                                    <div class="ratio-inner">
                                        <img style="border-radius:100%" src="/static/users/{{ $user->image }}" width="20px">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="books" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-hover my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>نوع مدرک</th>
                        <th>تعداد بازدید</th>
                        <th>امتیاز</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>{{ $b->title }}</td>
                        <td>{{ $b->type->title ?? '' }}</td>
                        <td>{{ $b->hits }}</td>
                        <td>{{ $b->score }}</td>
                        <td>{{ $b->status }}</td>
                        <td>{{ g2j($b->created_at) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info" href="{{ route('admin.books.show', $b->id) }}">مشاهده</a>
                            </div>
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
    </div>
    <div class="tab-pane fade" id="comments" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-hover my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>مدل مرتبط</th>
                        <th>شناسه مربوطه</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>
                            @if ($c->related_type == 'Codictive\Cms\Models\Book')
                                <a href="{{ route('admin.books.show', $c->related->id) }}">{{ $c->related->title }}</a>
                            @elseif($c->related_type == 'Codictive\Cms\Models\Author')
                                <a href="{{ route('admin.books.show', $c->related->id) }}">{{ $c->related->name }}</a>
                            @elseif($c->related_type == 'Codictive\Cms\Models\Quote')
                                نقل قول <a href="{{ route('admin.quotes.show', $c->related->id) }}">{{ $c->related->book->title }}</a>
                            @endif
                        </td>
                        <td>{{ $c->related_id }}</td>
                        <td>{{ $c->status }}</td>
                        <td>{{ g2j($c->created_at) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info" href="{{ route('admin.comments.show', $c->id) }}">مشاهده</a>
                            </div>
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
    </div>
    <div class="tab-pane fade" id="quotes" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-hover my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>کتاب</th>
                        <th>موافق</th>
                        <th>مخالف</th>
                        <th>هرزنامه</th>
                        <th>تایید شده/نشده</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $q)
                    <tr>
                        <td>{{ $q->id }}</td>
                        <td>{{ $q->book->title ?? '' }}</td>
                        <td>{{ $q->likes }}</td>
                        <td>{{ $q->dislikes }}</td>
                        <td>
                            @if($q->is_spam)
                            <span class="fas fa-check text-success"></span>
                            @else
                            <span class="fas fa-times text-danger"></span>
                            @endif
                        </td>
                        <td>
                            @if($q->is_approved)
                            <span class="fas fa-check text-success"></span>
                            @else
                            <span class="fas fa-times text-danger"></span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-info" href="{{ route('admin.quotes.show', $q->id) }}">مشاهده</a>
                            </div>
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
    </div>
</div>
<a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">بازگشت</a>
@endsection
