<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Post;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Category;

class PostsController extends Controller
{

    public function __construct() {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // upload image
        $image = $request->image->store('posts');
        // create post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category
        ]);
        // flash message
        session()->flash('success', 'Post created successfully.');
        // redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']);
        // check if new image
        if ($request->hasFile('image')) {
            // upload it
            $image = $request->image->store('posts');
            // delete old one
            $post->deleteImage();

            $data['image'] = $image;
        }
        
        // update attribute
        $post->update($data);

        // flash message
        session()->flash('success', 'Post updated successfully.');

        // redirect user
        return redirect(route('posts.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if ($post->trashed()) {
            $post->deleteImage();
            $post->forceDelete();
            session()->flash('success', 'Post deleted successfully.');
        } else {
            $post->delete();
            session()->flash('success', 'Post trashed successfully.');
        }
        
        return redirect(route('posts.index'));
    }

    /**
     * Display a list of all trashed posts
     */
    public function trashed() {
        // $trashed = Post::withTrashed()->get();

        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
        // return view('posts.index')->withPosts('posts', $trashed);
    }

    /**
     * restore the trashed post
     */
    public function restore($id) {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();
        
        session()->flash('success', 'Post restored successfully.');

        return redirect()->back();
    }
}
