@extends('layouts.app')
@section('main-app')

    <div class="container">
        <div class="mb-3 mt-3">
            <h1 class="text-center">Search with relationships in laravel-10</h1>
        </div>


        <div class="card-body">
            <div class="row py-2">
                <div class="col-md-8 mx-auto">
                    <div class="text-end">
                        <a href="{{ route('post.create') }}" class="btn btn-primary mb-2">Add new post</a>
                    </div>
                </div>
                <div class="col-md-8 mx-auto">
                    <div class="form-group">
                        <form action="/index" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search posts...">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($posts as $key => $post)
            <div class="col-lg-8 mx-auto mb-3">
                <div class="card" style="height: 100%;">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">Post by: {{ $post->user->name }}</p>
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">Category: {{ $post->category->name }}</p>
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">
                            Created at: {{ \Carbon\Carbon::parse($post->created_at)->isoFormat('Do MMMM YYYY') }}
                        </p>
                    </div>

                    <!-- Card image -->
                    <div class="card-img-top" style="overflow: hidden">
                        @if ($post->thumbnail === null)
                            <img src="https://dummyimage.com/200x200/000/fff" class="card-img-top" alt="">
                        @else
                            <a href="{{ asset('images/post/small/'. $post->thumbnail) }}" data-lightbox="post-images" data-title="Post Image">
                                <img src="{{ asset('images/post/small/'. $post->thumbnail) }}" class="card-img-top" alt="thumbnail"
                                style="height: 405px; width: 100%; object-fit:cover;">
                            </a>
                        @endif
                    </div>
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{!! wordwrap(substr($post->short_description, 0, 100), 50, "<br>\n", true) . "..." !!}</p>
                        <!-- Card buttons -->
                        <div class="d-flex justify-content-left align-items-center p-2">
                            <a href="{{ url('/post/show', ['post' => $post->id]) }}" class="btn btn-success m-1">Show</a>
                            <a href="{{ url('/post/edit', ['post' => $post->id]) }}" class="btn btn-warning m-1">Edit</a>
                            <a onclick="RemovePost({{ $post->id }})" href="#" class="btn btn-danger m-1">Delete</a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-3">
        {{$posts->links()}}
    </div>
@endsection
@section('customJs')
    <script>
         function RemovePost(postId) {
            // Perform actions with the image ID when clicked
            console.log('Clicked post ID:', postId);

            $.ajax({
                type: "DELETE",
                url: "{{ url('post/delete') }}" + '/' + postId,
                data: {
                    'id': postId
                },
                success: function (response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: "Success!",
                            text: "Post deleted successfully.",
                            icon: "success",
                            timer: 2000, // Set a timer to automatically close the alert after 2 seconds
                            showConfirmButton: false // Hide the "OK" button as the alert will close automatically
                        }).then(() => {
                            location.reload(); // Reload the page after the alert is closed
                        });
                    } else {
                        console.log('Failed to delete the post.'); // Handle the case where post deletion failed
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('Error deleting image:', error);
                }
            });
        }

    </script>
@endsection
