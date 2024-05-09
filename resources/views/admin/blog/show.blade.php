@extends('admin.index')

@section('title') {{ $post->title }} @endsection

@section('styles')

@endsection

@section('admin-content')
  
  <div class="container">
    <div class="misc-wrapper">
      <h2 class="mb-1 mx-2">{{ $post->title }}</h2>
      <a href="{{ route('posts.index') }}" class="btn btn-primary mb-4">Back to All Posts</a>
      <div class="mt-4 text-center">
        @if(isset($post->image) && $post->image != null)
            <img
            src="{{asset('/storage/'.$post->image)}}"
            alt="Content Image"
            width="550"
            class="img-fluid" />
        @endif
      </div>
      <p class="mb-2 mx-2">{!! $post->content !!}</p>
    </div>
  </div>
@endsection

@section('scripts')

<script src="{{asset ('assets/js/main.js') }}"></script>


  
@endsection