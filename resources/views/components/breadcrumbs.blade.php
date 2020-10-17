<section>
    <nav>
        <ol class="breadcrumb">
            @foreach($data as $value)
                @if($loop->last)
                    <li class="breadcrumb-item active">{{ Arr::get($value, 'title') }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ Arr::get($value, 'url') }}">
                            @if($loop->first)<i class="fas fa-tachometer-alt m-0 mr-1"></i>@endif
                            {{ Arr::get($value, 'title') }}
                        </a>
                        <i class="fas fa-angle-right"></i>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</section>
