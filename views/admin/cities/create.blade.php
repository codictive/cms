@extends('cms::layouts.admin')
@section('title', title('ایجاد شهر'))

@section('content')
<h1 class="fw-200">ایجاد شهر</h1>
<form method="post" action="{{ route('admin.cities.store', $province->id) }}">
    @csrf
    <div class="form-group">
        <label class="required" for="name">نام</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label class="required" for="weight">وزن</label>
        <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', '0') }}" required>
        @error('weight')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <input type="submit" class="btn btn-success" value="ذخیره">
    <a class="btn btn-outline-secondary" href="{{ route('admin.provinces.show', $province->id) }}">بازگشت</a>
</form>
@endsection
