@extends('components.layouts.base')

@section('content')
    <div>
        {{ \App\Utils\Breadcrumb::current('components.breadcrumbs', ['category' => $category->id, 'post' => $post->id]) }}

        {{ $post->title }}
    </div>
@endsection
