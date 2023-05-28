<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Post;

class ProfileController extends Controller
{
    public function profile(){
        $user=auth()->guard()->user();
        return ResponseHelper::success(new ProfileResource($user));
        }

        public function index(Request $request){
            $query=Post::Latest()->where('user_id',auth()->user()->id);
            if($request->category_id)
            {
                $query->where('category_id',$request->category_id);
            }
            if($request->search)
            {
                $query->where(function($query) use ($request){
                    $query->where('title','like','%'.$request->search.'%')
                            ->orWhere('description','like','%'.$request->search.'%');
                });
            }
            $posts=$query->paginate(5);
            return PostResource::collection($posts)->additional(['message'=>'success']);
            
        }
}
