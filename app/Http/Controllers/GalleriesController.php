<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GalleriesController extends Controller
{
    public function index()
    {
        return Gallery::with('images')->get();
    }
    public function store(Request $request, JWTAuth $auth)
    {
        $gallery = new Gallery();

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:galleries',
            'description' => 'required',
            'imgURL' => 'required'
        ]);
        if ($validator->fails()) 
        {
            return new JsonResponse($validator->errors(), 400);
        }

        $gallery->user_id = $auth->parseToken()->toUser()->id;
        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');
        $imgsURL = $request->input('imgURL');
        
        $gallery->save();
        
        foreach($imgsURL as $imgURL){
            $gallery->images()->create(['imgURL' => $imgURL]);
        }

        return $gallery;
    }
    public function show($id)
    {
        return Gallery::with('images','user')->find($id);
    }
}
