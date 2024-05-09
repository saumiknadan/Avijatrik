@extends('admin.index')
@section('title')
Edit | {{ $post->title }}
@endsection

@section('admin-content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">Edit </h5>
                        <div class="action-btns">
                            <a class="btn btn-label-primary me-3"  href="{{ route('posts.index') }}">
                            <span class="align-middle"> Back</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body" id="top">
                        <div class="row">
                            <div class="col-lg-10 mx-auto">
                                <form action="{{ route('posts.update', $post->id) }}"  method="POST" id="forms_data" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    {{-- Title --}}
                                    <div class="form-group">
                                        <label for="name">Title</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="title" 
                                            name="title" 
                                            value="{{ $post->title }}"
                                            />
                                    </div>
                                    {{-- Image --}}
                                    <div class="col-md-12 mt-4 form-group">
                                        <label for="formFile" class="form-label">Image</label>
                                        <input class="form-control" type="file" accept="image/*"  id="formFile" name="image" />                                                     
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <label>Previous Picture</label>
                                        @if(isset($post->image) && $post->image != null)
                                            <div class="ml-5">
                                                <img src="{{asset('/storage/'.$post->image)}}" alt="product image" width="40%" height="30%">
                                            </div><br>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="mt-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea
                                        type="text"
                                        class="ckeditor form-control "
                                        id="content" 
                                        name="content"
                                        aria-describedby="defaultFormControlHelp">{{ $post->content }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                                </form>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{ asset('assets/ckeditor/ckeditor.js')}}"></script>

{{-- CK Editor --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.ckeditor');
        textareas.forEach(function(textarea) {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script> 

{{-- <script>
    $(function () {
        $("#forms_data").on('submit', function (e) {
            e.preventDefault();
            $('#forms_data button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {
                    if (data.status == 0) {
                        var errorsHtml = '<div class="alert alert-danger">';
                        errorsHtml += '<div>';
                        $.each(data.error, function (field, messages) {
                            $.each(messages, function (index, message) {
                                errorsHtml += '<p>' + message + '</p>';
                            });
                        });
                        errorsHtml += '</div></div>';
                        $('#forms_data .alert-danger').remove();
                        $('#forms_data').prepend(errorsHtml);
                        $('html, body').animate({
                            scrollTop: $('#top').offset().top
                        }, 'slow');
                    } else {
                        if (data.status == 2) {
                            toastr.success(data.success);
                        } else {
                            $('#forms_data')[0].reset();
                            toastr.success(data.success);
                        }
                    }
                    $('#forms_data button[type="submit"]').prop('disabled', false);
                }
            });
        });
    });
</script> --}}

@endsection