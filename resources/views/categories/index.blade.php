@extends('components.layouts.base')

@section('content')
    <div>
        {{ \App\Utils\Breadcrumb::current('components.breadcrumbs') }}

        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('categories.show', ['category' => $category]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
