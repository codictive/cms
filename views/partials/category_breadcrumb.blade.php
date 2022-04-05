@php($br_index = 1)
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    @foreach($categories as $c)
        @if($br_index == count($categories))
        <li class="breadcrumb-item active" aria-current="page">{{ $c->name }}</li>
        @else
        <li class="breadcrumb-item"><a href="{{ route($route_name, $c->id) }}">{{ $c->name }}</a></li>
        @endif
        @php($br_index++)
    @endforeach
    </ol>
</nav>
