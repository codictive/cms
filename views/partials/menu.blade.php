<ul id="accordion"  class="{{ $class }}">
    @foreach($items as $i)
        @if($i['childs'])
        <li>
            <div class="link">{{ $i['title'] }}<i class="fa fa-chevron-down"></i>
            </div>
            <ul class="submenu" @if($i['active']) style="display:block;" @endif>
                @foreach ($i['childs'] as $c)
                <li>
                    <a @if($c['active']) class="active" @endif" href="{{ $c['path'] }}">{{ $c['title'] }}</a>
                </li>
                @endforeach
            </ul>
        </li>
        @else
        <li class="slide @if($i['active']) active @endif">
            <a class="link" href="{{ $i['path'] }}">{{ $i['title'] }}</a>
        </li>
        @endif
    @endforeach
</ul>
