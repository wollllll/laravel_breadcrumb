@extends('components.layouts.base')

@section('content')
    <div>
        {{ \App\Utils\Breadcrumb::current('components.breadcrumbs', ['category' => $category, 'post' => $post]) }}

        {{ $post->title }}
    </div>
@endsection
