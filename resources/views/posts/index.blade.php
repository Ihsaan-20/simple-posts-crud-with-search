@extends('layouts.app')
@section('main-app')
   
    <div class="container">
        <div class="card mt-2 mb-3">
            <div class="card-header">
                <div class="mb-3">
                    <h1 class="text-center">Search with relationships in laravel-10</h1>
                </div>
            </div>
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6">
                        <div>
                            <a href="{{ url('create') }}" class="btn btn-primary mb-2">Add new post</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <form action="/search" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search posts...">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>            
                {{-- <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Short Description</th>
                                <th scope="col">Post By</th>
                                <th scope="col">Post Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($posts as $key => $post )
                           <tr>
                            <td>{{$key + 1}}</td>
                            <td>
                                @if ($post->thumbnail === null)
                                    <img src="https://dummyimage.com/200x200/000/fff" class="img-fluid rounded-circle" width="60" height="60"   alt="">
                                @else
                                <div class="circular--portrait">
                                    <a href="{{ asset('images/post/small/'. $post->thumbnail) }}" data-lightbox="post-images" data-title="Post Image">
                                        <img src="{{ asset('images/post/small/'. $post->thumbnail) }}"  alt="thumbnail">
                                    </a>
                                </div>
    
                                @endif    
                            </td>
                            <td>{{$post->title}}</td>
                            <td>{!! wordwrap(substr($post->short_description, 0, 100), 50, "<br>\n", true) . "..." !!}</td>
    
                            <td>{{$post->user->name}}</td>
                            <td>{{$post->category->name}}</td>
                            <td>
                                <a href="{{ url('/show', ['post' => $post->id]) }}" class="btn btn-success m-1">Show</a>
    
                                <a href="{{ url('/edit', ['post' => $post->id]) }}" class="btn btn-warning m-1">Edit</a>
                                <a onclick="RemovePost({{ $post->id }})"  href="#" class="btn btn-danger m-1">Delete</a>
                            </td>
                           </tr>
    
                           @endforeach
    
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>

        <div class="card-body">
            <div class="row py-2">
                <div class="col-md-6">
                    <div>
                        <a href="{{ url('create') }}" class="btn btn-primary mb-2">Add new post</a>
                    </div>
                </div>
                <div class="col-md-6">
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
            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                <div class="card" style="height: 100%;">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">Post by: {{ $post->user->name }}</p>
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">Category: {{ $post->category->name }}</p>
                        <p class="text-muted m-0" style="font-size:12px; background-color:rgba(255,255,255,0.2)">
                            Created at: {{ \Carbon\Carbon::parse($post->created_at)->isoFormat('Do MMMM YYYY') }}
                        </p>
                    </div>

                    <!-- Card image -->
                    <div class="card-img-top">
                        @if ($post->thumbnail === null)
                            <img src="https://dummyimage.com/200x200/000/fff" class="card-img-top" alt="">
                        @else
                            <a href="{{ asset('images/post/small/'. $post->thumbnail) }}" data-lightbox="post-images" data-title="Post Image">
                                <img src="{{ asset('images/post/small/'. $post->thumbnail) }}" class="card-img-top" alt="thumbnail" 
                                style="height: 405px; width: 405px; object-fit:cover;">
                            </a>
                        @endif
                    </div>
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{!! wordwrap(substr($post->short_description, 0, 100), 50, "<br>\n", true) . "..." !!}</p>
                        <!-- Card buttons -->
                        <div class="mt-auto">
                            <a href="{{ url('/show', ['post' => $post->id]) }}" class="btn btn-success m-1">Show</a>
                            <a href="{{ url('/edit', ['post' => $post->id]) }}" class="btn btn-warning m-1">Edit</a>
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
                url: "{{ url('delete') }}" + '/' + postId,
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
