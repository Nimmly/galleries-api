<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Comment;
use App\User;
use Tymon\JWTAuth\JWTAuth;

class CommentsController extends Controller
{

    public function store($gallery_id, Request $request, JWTAuth $auth) 
    {    
        $comment = Gallery::find($gallery_id);
        $this->validate(request(),['text'=>'required|max:1000']);
        $comment->user_id = $auth->parseToken()->toUser()->id;
        $comment->comments()->create(request()->all());
    }
}
