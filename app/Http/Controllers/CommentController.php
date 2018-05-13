<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Comment;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required:min:1',
            'user_id' => 'required',
            'blog_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            $comment = Comment::create($request->all());
            return Response()->json($comment, 200);
        }
    }

    public function updateComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required:min:1',
            'user_id' => 'required',
            'blog_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            $comment = Comment::find($id);
            if($comment){
                $comment = $comment->update($request->all());
                return Response()->json($comment, 201);
            } else {
                return Response()->json('Post not found', 404);
            }
        }
        
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if($comment){
            $comment->delete();
            return Response()->json($comment, 204);
        } else {
            return Response()->json('Post not found', 404);
        }
    }
}
