<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use App\Blog;

class BlogController extends Controller
{
    public function createBlogPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blogs',
            'content' => 'required:min:10',
            'user_id' => 'required'
        ]);
        $input = $request->all();
        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            if($request->hasFile('main_image')){
                $input['main_image'] = $request->main_image->store('public/blogImages');
            }
            $post = Blog::create($input);
            return Response()->json($post, 200);
        }
    }

    public function getBlogPost($id)
    {
        $post = Blog::with('comments')->with('user')->find($id);

        if($post){
            return Response()->json($post, 200);
        } else {
            return Response()->json('Post not found', 404);
        }
    }

    public function getBlogPosts()
    {
        $posts = Blog::with('user')->paginate(30);

        if($posts->count()){
            return Response()->json($posts, 200);
        } else {
            return Response()->json('Not found any posts', 404);
        }
    }

    public function updateBlogPost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required:min:10',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            $input = $request->all();
            $post = Blog::find($id);
            if($post){
                if($request->hasFile('main_image')){
                    Storage::delete($post->main_image);
                    $input['main_image'] = $request->main_image->store('public/blogImages');
                }
                $post = $post->update($input);
                return Response()->json($post, 201);
            } else {
                return Response()->json('Post not found', 404);
            }
        }
        
    }

    public function deleteBlogPost($id)
    {
        $post = Blog::find($id);
        if($post){
            $post->comments()->delete();
            Storage::delete($post->main_image);
            $post->delete();
            return Response()->json($post, 204);
        } else {
            return Response()->json('Post not found', 404);
        }
    }
}
