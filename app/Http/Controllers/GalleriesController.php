<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GalleriesController extends Controller
{
    public function index()
    {
        return Gallery::with('images','user')->get();
    }
    public function showUserGalleries($user_id)
    {
        return Gallery::with('images')->where('user_id', $user_id)->get();
    }
    public function store(Request $request, JWTAuth $auth)
    {
        $gallery = new Gallery();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255|unique:galleries',
            'description' => 'max:1000',
            'imgURL' => 'required'
        ]);
        if ($validator->fails()) 
        {
            return new JsonResponse($validator->errors(), 400);
        }

        $gallery->user_id = $auth->parseToken()->toUser()->id;
        $gallery->name = $request['name'];
        $gallery->description = $request['description'];
        $imgsURL = $request['imgURL'];
        
        $gallery->save();
        
        // foreach($imgsURL as $imgURL){
        //     $gallery->images()->create(['imgURL' => $imgURL]);
        // }
        foreach($imgsURL as $imgURL){
            $img = new Image();
            $img->imgURL = $imgURL['url'];
            $img->gallery_id = $gallery->id;
            $img->save();
            $result[] = $img;
        }
        return $gallery;
    }
    public function show($id)
    {
        return Gallery::with('images','user','comments')->find($id);
    }
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
        return new JsonResponse(true);
    }
}
