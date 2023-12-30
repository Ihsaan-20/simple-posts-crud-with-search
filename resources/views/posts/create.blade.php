@extends('layouts.app')
@section('main-app')
<div class="row">
   <div class="col-lg-6 mx-auto">
        <div class="card mt-4">
            <div class="card-header">
                <h1>Add a post</h1>
            </div>
            <div class="card-body">
                <form action="{{ url('/store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="mb-3">
                        <label for="">Post Title</label>
                        <input type="text" name="title" class="form-control" placeholder="enter post title..">
                    </div>

                    <div class="mb-3">
                        <label for="">Post Short Description</label>
                        <textarea name="short_description" class="form-control" id="" cols="30" rows="10"></textarea>
                        {{-- <input type="text" name="short_description" class="form-control"> --}}
                    </div>

                    <div class="mb-3">
                        <label for="">User ID</label>
                        <select name="user_id" id="" class="form-control">
                            <option value="1">user 1</option>
                            <option value="2">user 2</option>
                            <option value="3">user 3</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="">Post Category</label>
                        <select name="category_id" id="" class="form-control">
                            <option value="1">category 1</option>
                            <option value="2">category 2</option>
                            <option value="3">category 3</option>
                        </select>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="">User ID</label>
                        <input type="text" name="user_id" value="1" class="form-control">
                    </div> --}}

                    {{-- <div class="mb-3">
                        <label for="">Post Category</label>
                        <input type="text" name="category_id" value="1" class="form-control">
                    </div> --}}


                    <div class="mb-3">
                        <label for="">Post Image</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Post More Images</label>
                        <input type="file" name="multi_images[]" multiple class="form-control">
                    </div>


                    <div class="card-footer">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Image</button>
                            <button type="button" onclick="window.location.href='{{ url('/') }}' " class="btn btn-default">Go Back</button>
                        </div>

                    </div>
                    
                </form>
            </div>
        </div>
   </div>
</div>

@endsection