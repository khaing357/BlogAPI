<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use App\Models\Post;
use App\Models\Media;

class PostController extends Controller
{
    public function index(Request $request){
        $query=Post::Latest();
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

    public function show($id){
        $post=Post::where('id',$id)->firstOrFail();
        return ResponseHelper::success(new PostDetailResource($post));

    }
    
    public function create(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'description'=>'required|string',
            'category_id'=>'required',
            'user_id'=>'required'
        ],
        [
          'category_id.required'=>'The category field is required.',
          'user_id.required'=>'The author is required.' 
        ]);
        
        DB::beginTransaction();
        try{
            if($request->hasFile('image')){
                $file=$request->file('image');
                $file_name=uniqid().'-'.date('Y-m-d-H-m-s').'.'.$file->getClientOriginalExtension();
                Storage::put('media/'.$file_name ,file_get_contents($file));
            }
            
            $post=new Post();
            $post->title=$request->title;
            $post->description=$request->description;
            $post->category_id=$request->category_id;
            $post->user_id=auth()->user()->id;

            $post->save();
    
            $media=new Media();
            $media->file_name=$file_name;
            $media->file_type='image';
            $media->model_id=$post->id;
            $media->model_type=Post::class;
            $media->save();
            DB::commit();
            return ResponseHelper::success([],'Successfully uploaded');

        }catch(Exception $e){
            DB::rollBack();
            return ResponseHelper::fail($e->getMessage());
        }
        
    }
}
