{{-- The Post Page Layout --}}
@extends('layouts.app')
@section('content')

<main class="mx-auto max-w-7xl py-16 px-8 lg:mt-8">
	@include('post.article')
</main>

@endsection
