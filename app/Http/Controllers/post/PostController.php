<?php

namespace App\Http\Controllers\post;

use App\Models\Post;
use App\Models\Category;

use App\Models\PostImages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PostController extends Controller
{
    // public function getSlug(Request $request)
    // {
    //     // dd($request->all());
    //     $slug = '';
    //     if( !empty($request->title)){
    //         $slug = Str::slug($request->title);
    //     }
    //     return response()->json([
    //         'status' => true,
    //         'slug' => $slug
    //     ]);
    // }

    public function index(Request $request)
    {
        // dd($request->input('search'));
        $pageTitle = '__All Post__'; // Your dynamic page title
        $search = $request->input('search');
        if($search)
        {
            $posts =  Post::where('title', 'like', "$search")->paginate(6);
        }else{
            $posts =  Post::latest()->paginate(6);
        }
        return view('posts.index', compact('posts','pageTitle', 'search'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::with('user', 'category')
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('short_description', 'like', "%$search%");
            })
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(10);

        return view('posts.index', compact('posts', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $pageTitle = 'Create post'; // Your dynamic page title
        return view('posts.create', compact('pageTitle', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = new Post();
        $data->user_id = '1';
        $data->category_id = $request->category_id;
        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->status = $request->status;
        $data->short_description = $request->short_description;
        $data->long_description = $request->long_description;
        $data->is_featured = $request->is_featured;

        $tags = $request->input('tags');
        $tagsArray = explode(' ', $tags);
        $tagsArray = array_filter($tagsArray);
        $jsonEncodedTags = json_encode($tagsArray);

        $data->tags = $jsonEncodedTags;


        $data->save();

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnailDirectory = public_path('images/post/small');
            $thumbnail->move($thumbnailDirectory, $thumbnailName);

            // $data->thumbnail = $thumbnailDirectory . '/' . $thumbnailName; // Saving the thumbnail path in the database
            $data->thumbnail = $thumbnailName; // Saving the thumbnail path in the database
            $data->save();
        }
        // dd($thumbnailDirectory);


        if ($request->hasFile('multi_images')) {
            $imageNames = [];

            foreach ($request->file('multi_images') as $postImage) {
                if ($postImage->isValid()) {
                    $postImageName = time().'-'.$postImage->getClientOriginalName();
                    $imageDirectory = public_path('images/post/large');
                    $postImage->move($imageDirectory, $postImageName);
                    $imageNames[] = $postImageName; // Store only the image names
                }
            }
            // dd($imageNames);

            $data->save();
            $user_id = $data->user_id;

            foreach ($imageNames as $imageName) {
                $multi_image = new PostImages();
                $multi_image->post_id = $data->id;
                $multi_image->user_id = $user_id;
                $multi_image->image = $imageName;
                $multi_image->save();
            }
        }

        return redirect('/')->with('success', 'Post created successfully!');


    }


    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $pageTitle = "Show Page";
        $postWithImages = Post::with('images', 'user','category')->find($id);

        return view('posts.show', ['post' => $postWithImages, 'pageTitle' => $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($post->id);
        $pageTitle = "Edit page";
        $categories = Category::get();
        $post = Post::with('images', 'user','category')->find($id);

        // dd($post->tags);
        if($post){
            return view('posts.edit', compact('categories', 'post', 'pageTitle'));
        }else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $data = Post::findOrFail($request->id);


        if($data)
        {
            $data->user_id = '1';
            $data->category_id = $request->category_id;
            $data->title = $request->title;
            $data->slug = $request->slug;
            $data->status = $request->status;
            $data->short_description = $request->short_description;
            $data->long_description = $request->long_description;
            $data->is_featured = $request->is_featured;

            $tags = $request->tags;
            $tagsArray = explode(' ', $tags);
            $tagsArray = array_filter($tagsArray);
            $jsonEncodedTags = json_encode($tagsArray);

            $data->tags = $jsonEncodedTags;

            $data->save();

            // thumbnail image;
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = $thumbnail->getClientOriginalName();
                $thumbnailDirectory = public_path('images/post/small');
                // Delete old thumbnail image if it exists
                if ($data->thumbnail && file_exists($thumbnailDirectory . '/' . $data->thumbnail)) {
                    unlink($thumbnailDirectory . '/' . $data->thumbnail);
                }
                $thumbnail->move($thumbnailDirectory, $thumbnailName);
                $data->thumbnail = $thumbnailName; // Update the thumbnail path in the database
            }
            $data->save();
            // update multiple images;
            if ($request->hasFile('multi_images')) {
                $existingImages = $data->images()->pluck('image')->toArray(); // Get existing image names

                foreach ($request->file('multi_images') as $postImage) {
                    if ($postImage->isValid()) {
                        $postImageName = time() . '-' . $postImage->getClientOriginalName();
                        $imageDirectory = public_path('images/post/large');
                        $postImage->move($imageDirectory, $postImageName);
                        $imageNames[] = $postImageName; // Store only the image names
                    }
                }

                // Remove existing images from storage and database
                foreach ($existingImages as $existingImage) {
                    if (in_array($existingImage, $imageNames)) {
                        continue; // Skip images that are in the new list
                    }

                    // Delete image from storage
                    $imagePath = $imageDirectory . '/' . $existingImage;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    // Delete image from database
                    $data->images()->where('image', $existingImage)->delete();
                }

                // Save new images to database
                $user_id = $data->user_id;
                foreach ($imageNames as $imageName) {
                    $multi_image = new PostImages();
                    $multi_image->post_id = $data->id;
                    $multi_image->user_id = $user_id;
                    $multi_image->image = $imageName;
                    $multi_image->save();
                }
            }




        }


        // dd($request->all());
        return back()->with('success', 'Post updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $post = Post::with('images')->findOrFail($id);

        // Delete the associated thumbnail image
        $thumbnailImage = $post->thumbnail;
        if ($thumbnailImage) {
            $thumbnailPath = public_path('images/post/small/' . $thumbnailImage);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
            $post->thumbnail = null; // Clear the thumbnail reference in the post
            $post->save();
        }

        // Delete the associated post images
        if ($post->images) {
            foreach ($post->images as $image) {
                $imagePath = public_path('images/post/large/' . $image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $post->images()->delete(); // Delete all associated post images
        }

        // Finally, delete the post
        $post->delete();

        return response()->json(['status' => true, 'message' => 'Post and associated images deleted successfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPostMultiImage($id)
    {
        $postImage = PostImages::findOrFail($id);

        if ($postImage) {
            // Get the image file name from the PostImages model
            $imageFileName = $postImage->image;

            // Delete the image record
            $postImage->delete();

            // Delete the image file from storage
            if ($imageFileName) {
                unlink('images/post/large/' . $imageFileName);
            }

            return response()->json(['status' => true, 'message' => 'Image deleted!'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Image not found!'], 404);
        }
    }


    public function destroyPostThumbnailImage($id)
    {
        $post = Post::findOrFail($id);

        if ($post) {
            $thumbnailImage = $post->thumbnail;
            if ($thumbnailImage) {
                unlink('images/post/small/' . $thumbnailImage);
                $post->thumbnail = null;
                $post->save();

                return response()->json(['status' => true, 'message' => 'Thumbnail image deleted!'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Thumbnail image not found for the post!'], 404);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Post not found!'], 404);
        }
    }
}
