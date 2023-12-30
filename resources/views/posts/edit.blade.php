@extends('layouts.app')
@section('main-app')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card mt-4">
                <div class="card-header">
                    <h1>Add a post</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url('/update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('put')

                        <input type="hidden" name="user_id" value="{{ $post->user->id }}">
                        <input type="hidden" name="category_id" value="{{ $post->category->id }}">
                        <div class="mb-3">
                            <label for="">Post Title</label>
                            <input type="text" name="title" value="{{ $post->title }}" class="form-control"
                                placeholder="enter post title..">
                        </div>

                        <div class="mb-3">
                            <label for="">Post Short Description</label>
                            <textarea name="short_description" class="form-control" id="" cols="30" rows="10">{{ $post->short_description }}</textarea>
                            {{-- <input type="text" name="short_description" class="form-control"> --}}
                        </div>

                        <div class="mb-3">
                            <label for="">Post Image</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>

                        @if ($post->thumbnail === null)
                            <p class="text-danger">No Thumbnail!</p>
                        @else
                            <div class="circular--portrait mb-3">
                                <a href="#" type="button" onclick="RemoveThumbnail({{ $post->id }})" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                    title=" Click to remove">
                                    <img src="{{ asset('images/post/small/' . $post->thumbnail) }}" alt="thumbnail">
                                </a>

                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="">Post More Images</label>
                            <input type="file" name="multi_images[]" multiple class="form-control">
                        </div>

                        <div class="d-flex flex-row gap-2">
                            @if ($post->images->isNotEmpty())
                                @foreach ($post->images as $image)
                                    <div class="circular--portrait mb-3">
                                        
                                        <a href="#" type="button" onclick="RemoveMultiImage({{ $image->id }})" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" 
                                            title=" Click to remove">
                                            <img src="{{ asset('images/post/large/' . $image->image) }}" class="img-fluid" alt="Image">
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-danger">No images found!!!</p>
                            @endif
                        </div>



                        <div class="card-footer">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Post</button>
                                <button type="button" onclick="window.location.href='{{ url('/') }}' "
                                    class="btn btn-default">Go Back</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('customJs')
    <script>
         function RemoveMultiImage(imageId) {
            // Perform actions with the image ID when clicked
            console.log('Clicked image ID:', imageId);

            $.ajax({
                type: "DELETE",
                url: "{{ url('post/multi/image/') }}" + '/' + imageId,
                data: {
                    'id': imageId
                },
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    location.reload(); 
                    console.log('Image deleted successfully.');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('Error deleting image:', error);
                }
            });
        }

        function RemoveThumbnail(imageId) {
            // Perform actions with the image ID when clicked
            console.log('Clicked image ID:', imageId);

            $.ajax({
                type: "DELETE",
                url: "{{ url('post/thumbnail/image/') }}" + '/' + imageId,
                data: {
                    'id': imageId
                },
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    location.reload(); 
                    console.log('Image deleted successfully.');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('Error deleting image:', error);
                }
            });
        }



        $(document).ready(function (){
           


        });
    </script>
@endsection
