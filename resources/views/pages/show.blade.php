@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)

@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ $page->title }}</h1>
            <div class="content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection 