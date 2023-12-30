@extends('layouts.app')
@section('main-app')
    <form action="{{ route('post.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card mt-4">
            <div class="card-header">
                <h1>Update post</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class=" mt-3 me-2 text-end">
                        <button type="button" onclick="window.location.href='{{ url('/') }}'" class="btn btn-default">Go
                            Back</button>
                        <button type="submit" class="btn btn-success">Update Post</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">


                        <div class="mb-3">
                            <label for="">Post Title</label>
                            <input type="text" name="title" value="{{ $post->title }}" class="form-control"
                                placeholder="enter post title..">
                        </div>

                        <div class="mb-3">
                            <label for="">Post Short Description</label>
                            <textarea name="short_description" class="form-control" id="summernote" cols="30" rows="10">{!! $post->short_description !!}</textarea>
                            {{-- <input type="text" name="short_description" class="form-control"> --}}
                        </div>

                        <div class="mb-3">
                            <label for="">Post Long Description</label>
                            <textarea name="long_description" class="form-control" id="summernote" cols="30" rows="10">{!! $post->long_description !!}</textarea>
                            {{-- <input type="text" name="short_description" class="form-control"> --}}
                        </div>

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

                    </div>
                    {{-- col end here --}}
                    <div class="col-lg-4">


                        <div class="mb-3">
                            <label for="">Featured Image</label>
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
                            <label for="">Slug</label>
                            <input type="text" id="slug" placeholder="Slug" readonly name="slug" value="{{$post->slug}}" class="form-control">
                        </div>



                        <div class="mb-3">
                            <label for="">Post Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select status</option>
                                <option value="draft" {{$post->status === 'draft' ? 'selected' : ''}}>Draft</option>
                                <option value="published" {{$post->status === 'published' ? 'selected' : ''}}>Published</option>
                                <option value="pending" {{$post->status === 'pending' ? 'selected' : ''}}>Pending</option>
                                <option value="review" {{$post->status === 'review' ? 'selected' : ''}}>Review</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="">Post Category</label>
                            <select name="category_id" id="" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category->id === $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" {{ $post->is_featured === 1 ? 'checked' : '' }} name="is_featured" id="flexCheckIndeterminate">
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                    Is Featured Post
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="">Tags</label>
                            <textarea name="tags" id="tags" class="form-control" cols="2" rows="2">@if($post->tags)@foreach(json_decode($post->tags) as $tag){{ $tag }} @endforeach @endif</textarea>

                        </div>



                    </div>


                </div>
            </div>
        </div>
        {{-- row end here --}}
    </form>
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
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    location.reload();
                    alert('Image deleted successfully.');
                },
                error: function(xhr, status, error) {
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
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    location.reload();
                    alert('Image deleted successfully.');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error deleting image:', error);
                }
            });
        }



        $(document).ready(function() {



        });
    </script>
@endsection
