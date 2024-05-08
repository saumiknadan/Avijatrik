@extends('admin.index')

@section('title') Category @endsection

@section('styles')

@endsection

@section('admin-content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
          <h5 class="card-title mb-sm-0 me-2">All Category</h5>
          <div class="action-btns">
            <a class="btn btn-primary" href="{{ route('posts.create') }}">Create New Post</a>
          </div>
        </div>
        <div class="card-body">

          {{-- Modal for Delete --}}
          <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this item?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
          </div> 

          @include('admin.partials.messages')
              {{-- Table start --}}
          <table class="table table-striped table-product text-center" style="width:100%">
            <thead>
              <th width="15%">Sl</th>
              <th width="25%">Title</th>
              <th width="45%">Status</th>
              <th width="15%">Action</th>
            </thead>
  
            <tbody class="table-border-bottom-0">
              @foreach ($posts as $index => $post)
              <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $post->title }}</td>
                  
                  <td class="">
                    @if($post->status==1)
                      <span class="badge bg-label-success">Active</span>
                    @else
                      <span class="badge bg-label-danger">Deactive</span>
                      @endif
                  </td>

                <!-- Action Button -->
                <td>
                  <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="ti ti-dots-vertical"></i>
                  </button>
                  
                  <div class="dropdown-menu">
                        @if($post->status==1)
                        <a href="{{route('posts.status',$post->id)}}" class="dropdown-item edit-btn" >
                          <i class="ti ti-thumb-down me-1"></i> Deactivate  
                        </a>
                        @else
                        <a href="{{route('posts.status',$post->id)}}" class="dropdown-item edit-btn" >
                          <i class="ti ti-thumb-up me-1"></i> Activate
                        </a>                            
                      @endif
                     <a class="dropdown-item edit-btn" href="{{route('posts.edit', $post->id)}}">
                          <i class="ti ti-pencil me-1"></i> Edit
                      </a>
                   
                    {{-- Delete Button --}}
                    {{-- @if (Auth::user()->can('category.delete'))
                      <form id="deleteForm" action="{{route('categories.destroy', $category->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item delete-btn" type="button">
                            <i class="ti ti-trash me-1"></i> Delete
                        </button>
                      </form>
                    @endif --}}

                  </div>
                  </div>
                </td>
            

              </tr>
              @endforeach
            </tbody>
          </table>
        
      </div>
    </div>
  </div>
@endsection

@section('scripts')

<script src="{{asset ('assets/js/main.js') }}"></script>

  <!-- Page JS -->

  <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
{{-- delete popup --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.delete-btn');
    var confirmDeleteButton = document.getElementById('confirmDeleteButton');
    var deleteForm = document.getElementById('deleteForm');
    var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            deleteConfirmationModal.show();
        });
    });

    confirmDeleteButton.addEventListener('click', function() {
        deleteForm.submit();
    });
});

</script>
  
@endsection