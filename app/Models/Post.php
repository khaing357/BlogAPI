<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
use App\Models\Category;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function image(){
        return $this->morphOne(Media::class,'model');
    }
    
}