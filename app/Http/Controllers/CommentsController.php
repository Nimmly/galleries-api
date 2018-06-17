<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Comment;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;



class CommentsController extends Controller
{

    public function store($gallery_id, Request $request, JWTAuth $auth) 
    {    
        $comment = new Comment();
        $this->validate(request(), ['text' => 'required|max:1000']);
        $comment->user_id = $auth->parseToken()->toUser()->id;
        $comment->gallery_id = $gallery_id;
        $comment->text = request('text');
        $comment->save();

    }

    public function destroy($id,$comment_id)
    {
        $comments = Comment::where('gallery_id', $id)->where('id', $comment_id)->delete();

        return new JsonResponse(true);
    }
}
