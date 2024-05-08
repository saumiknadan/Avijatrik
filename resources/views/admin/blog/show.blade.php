@extends('admin.index')

@section('title') Category @endsection

@section('styles')

@endsection

@section('admin-content')
  {{-- <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
          <h5 class="card-title mb-sm-0 me-2">All Content</h5>
          <div class="action-btns">
            <a class="btn btn-primary" href="{{ route('posts.create') }}">Create New Post</a>
          </div>
        </div>
        <div class="card-body">

        
      </div>
    </div>
  </div> --}}
  <div class="container">
    <div class="misc-wrapper">
      <h2 class="mb-1 mx-2">{{ $post->title }}</h2>
      <a href="{{ route('posts.index') }}" class="btn btn-primary mb-4">Back to All Blog</a>
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