<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'category_name'=>optional($this->category)->name ?? "Unknown Category",
            'author_name'=>optional($this->author)->name ?? "Unknown Author",
            'created_at'=>$this->created_at->diffForHumans(),
            'title'=>$this->title,
            'description'=>$this->description,
            'image_path'=>$this->image ? asset("storage/media/".$this->image->file_name) : null,
            
        ];
    }
}
