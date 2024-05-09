@extends('admin.index')

@section('title') All Posts @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css')}}" />


<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
@endsection

@section('admin-content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
          <h5 class="card-title mb-sm-0 me-2">All Content</h5>
          <div class="action-btns">
            <a class="btn btn-primary" href="{{ route('posts.create') }}">Create New Post</a>
          </div>
        </div>
        <div class="card-body">
          {{-- Filter --}}
          <div class="row">
            <div class="col-md-12 mb-3">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="row">
                        <!-- Start Date Input -->
                        <div class="col-md-3">
                          <label for="start_date" class="form-label">Start Date:</label>
                          <input type="text" class="form-control start_date" id="start_date" name="start_date" value="{{ request()->input('start_date') ?? $startDate ?? '' }}">
                        </div>

                        <!-- End Date Input -->
                        <div class="col-md-3">
                          <label for="end_date" class="form-label">End Date:</label>
                          <input type="text" class="form-control end_date" id="end_date" name="end_date" value="{{ request()->input('end_date') ?? $endDate ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label for="user_id" class="form-label">User:</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
              {{-- Table start --}}
              <table class="table table-striped table-product" style="width:100%">
                <thead>
                    <tr>
                        <th width="15%" class="text-center">Sl</th>
                        <th width="20%" class="text-center">Title</th>
                        <th width="10%" class="text-center">Image</th>
                        <th width="20%" class="text-center">Content</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}</td>
                        <td class="text-center">{{ $post->title }}</td>
                        <td class="text-center">
                            @if(isset($post->image) && $post->image != null)
                                <img width="42px" height="42px" alt class=" rounded-circle" src="{{asset('/storage/'.$post->image)}}">
                            @endif
                        </td>
                        <td class="text-justify">
                          @php
                              $content = $post->content;
                              if (strlen($content) > 50) {
                                  $shortened_content = substr($content, 0, 80);
                                  $content = $shortened_content . '..... <a href="' . route('posts.show', $post->id) . '">Continue Read</a>';
                              }
                          @endphp
                          {!! $content !!}
                        </td>
                        <td class="text-center">
                            @if($post->status==1)
                            <span class="badge bg-label-success">Active</span>
                            @else
                            <span class="badge bg-label-danger">Deactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit-btn" href="{{route('posts.show', $post->id)}}">
                                      <i class="ti ti-eye me-1"></i> Show
                                    </a>
                                    @if($post->status==1)
                                    <a href="{{route('posts.status',$post->id)}}" class="dropdown-item edit-btn">
                                        <i class="ti ti-thumb-down me-1"></i> Deactivate
                                    </a>
                                    @else
                                    <a href="{{route('posts.status',$post->id)}}" class="dropdown-item edit-btn">
                                        <i class="ti ti-thumb-up me-1"></i> Activate
                                    </a>
                                    @endif
                                    <a class="dropdown-item edit-btn" href="{{route('posts.edit', $post->id)}}">
                                        <i class="ti ti-pencil me-1"></i> Edit
                                    </a>

                                    <form id="deleteForm" action="{{route('posts.destroy', $post->id)}}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button class="dropdown-item delete-btn" type="button">
                                          <i class="ti ti-trash me-1"></i> Delete
                                      </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="row mt-4">
                <span class="mt-2">{{ $posts->links('vendor.pagination.bootstrap-5') }}</span>
            </div>
            
      </div>
    </div>
  </div>
@endsection

@section('scripts')

<script src="{{asset ('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    

    <!-- Page JS -->
    <script src="{{ asset('assets/js/forms-pickers.js')}}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script> --}}

    <!-- Page JS -->
    <script src="{{ asset('assets/js/forms-selects.js')}}"></script>

<!-- Page JS -->

  <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
  
  {{-- Date --}}

<script>
    const datepick = document.querySelector('.start_date');
        flatpickr(datepick, {
            dateFormat: "d-m-Y"
        });
</script>

<script>
  const datepick1 = document.querySelector('.end_date');
      flatpickr(datepick1, {
          dateFormat: "d-m-Y"
      });
</script>
@endsection