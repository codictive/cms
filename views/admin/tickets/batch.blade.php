@extends('cms::layouts.admin')

@section('title', title('عملیات گروهی'))

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">مقالات</a></li>
    <li class="breadcrumb-item active" aria-current="page">عملیات گروهی</li>
  </ol>
</nav>
<form method="post" action="{{ route('admin.tickets.batch') }}">
    @csrf
    <div class="row">
        @if($action == 'status')
        <div class="col-md-12">
            <div class="form-group">
                @foreach ($ticketIds as $id)
                <input type="hidden" name="batch[]" value="{{ $id }}">
                @endforeach
                <input type="hidden" name="action" value="store_status">
                <label for="status">وضعیت</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">-- انتخاب کنید --</option>
                    @foreach ($status as $s)
                    <option value="{{ $s }}" @if(old('status') == $s) selected @endif>{{ $s }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        @endif
        <div class="col-12">
            <input type="submit" class="btn btn-success" value="ذخیره">
            <a class="btn btn-outline-secondary" href="{{ route('admin.tickets.index') }}">بازگشت</a>
        </div>
    </div>
</form>
@endsection
