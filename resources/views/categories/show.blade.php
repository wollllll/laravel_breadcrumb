@extends('components.layouts.base')

@section('content')
    <div>
        {{ \App\Utils\Breadcrumb::current('components.breadcrumbs', ['category' => $category]) }}

        <ul>
            @foreach($category->posts as $post)
                <li>
                    <a href="{{ route('posts.show', ['category' => $category, 'post' => $post]) }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
