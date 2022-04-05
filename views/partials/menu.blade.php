<ul class="{{ $class }}">
    @foreach($items as $i)
        @if($i['childs'])
        <li class="nav-item dropdown @if($i['active']) active @endif">
            <a class="nav-link dropdown-toggle" href="{{ $i['path'] }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $i['title'] }}</a>
            <div class="dropdown-menu">
                @foreach ($i['childs'] as $c)
                <a class="dropdown-item @if($c['active']) active @endif" href="{{ $c['path'] }}">{{ $c['title'] }}</a>
                @endforeach
            </div>
        </li>
        @else
        <li class="nav-item @if($i['active']) active @endif">
            <a class="nav-link" href="{{ $i['path'] }}">{{ $i['title'] }}</a>
        </li>
        @endif
    @endforeach
</ul>
