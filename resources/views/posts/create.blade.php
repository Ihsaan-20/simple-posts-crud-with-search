@extends('layouts.app')
@section('main-app')
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mt-4">
            <div class="card-header">
                <h1>Add a post</h1>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class=" mt-3 me-2 text-end">
                        <button type="button" onclick="window.location.href='{{ url('/') }}' "
                        class="btn btn-default">Go Back</button>
                        <button type="submit" class="btn btn-success">Add Post</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">


                        <div class="mb-3">
                            <label for="">Post Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Post title..">
                        </div>

                        <div class="mb-3">
                            <label for="">Post Short Description</label>
                            <textarea name="short_description" class="form-control" id="summernote"  cols="30" rows="10"></textarea>
                            {{-- <input type="text" name="short_description" class="form-control"> --}}
                        </div>

                        <div class="mb-3">
                            <label for="">Post Long Description</label>
                            <textarea name="long_description" class="form-control" id="summernote" cols="30" rows="10"></textarea>
                            {{-- <input type="text" name="short_description" class="form-control"> --}}
                        </div>

                        <div class="mb-3">
                            <label for="">Post More Images</label>
                            <input type="file" name="multi_images[]" multiple class="form-control">
                        </div>

                    </div>
                    {{-- col end here --}}
                    <div class="col-lg-4">


                        <div class="mb-3">
                            <label for="">Featured Image</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Slug</label>
                            <input type="text" id="slug"  placeholder="Slug" name="slug" class="form-control">
                        </div>



                        <div class="mb-3">
                            <label for="">Post Status</label>
                            <select name="status" id="" class="form-control">
                                <option selected disabled>Select status</option>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="pending">Pending</option>
                                <option value="review">Review</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="">Post Category</label>
                            <select name="category_id" id="" class="form-control">
                                <option selected disabled>Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="flexCheckIndeterminate">
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                  Is Featured Post
                                </label>
                              </div>
                        </div>

                        <div class="mb-3">
                            <label for="">Tags</label>
                            <textarea  name="tags" id="tags" class="form-control" cols="2" rows="2"></textarea>
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
$(document).ready(function() {

    $('#title').change(function(){
        element = $(this);
        $('button[type=submit]').prop('disabled', true);
            $.ajax({
            url: '{{route('slug')}}',
            type: 'get',
            data: { title:element.val() },
            dataType: 'json',
            success:function(response){
                console.log('success');
                $('button[type=submit]').prop('disabled', false);

                if(response['status'] == true){
                    $('#slug').val(response['slug']);
                }
            }
        });
    });
});


</script>
@endsection
