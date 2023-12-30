@extends('layouts.app')
@section('main-app')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div>
                <a href="{{ url('/') }}"><- Go Back</a>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    <h1>{{ $post->title }}</h1>
                </div>
                <div class="card-body">
                   <div>
                        <p>{{ $post->short_description }}</p>
                   </div>

                  <div class="row">
                    @if($post->images->isNotEmpty())
                        @foreach($post->images as $image)
                            <div class="col-md-4 mb-2">
                                <a href="{{ asset('images/post/large/'.$image->image) }}" data-lightbox="post-images" data-title="Post Image" target="_blank">
                                    <img src="{{ asset('images/post/large/'.$image->image) }}" class="img-fluid" alt="Image">
                                </a>
                            </div>
                        @endforeach
                    @else 

                        <div class="col-md-4 mb-2">
                            <img src="https://dummyimage.com/200x200/000/fff" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-4 mb-2">
                            <img src="https://dummyimage.com/200x200/000/fff" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-4 mb-2">
                            <img src="https://dummyimage.com/200x200/000/fff" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-4 mb-2">
                            <img src="https://dummyimage.com/200x200/000/fff" class="img-fluid" alt="">
                        </div>

                    @endif
                    
                    
                    
                  </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-evenly align-items-center">
                        <p class="p-1 rounded" style="background-color: rgb(255,209,45)">Post by: {{ $post->user->name }}</p>
                        <p class="p-1 rounded" style="background-color: rgb(255,209,45)">Category: {{ $post->category->name }}</p>
                        <p class="p-1 rounded" style="background-color: rgb(255, 209, 45)">
                            Created at: {{ \Carbon\Carbon::parse($post->created_at)->isoFormat('Do MMMM YYYY, h:mm A') }}
                        </p>
                        
                        
                    </div>
                </div>

            </div>

            
            
        </div>
    </div>
</div>

@endsection