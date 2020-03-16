<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;
    
    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'category_id'
    ];


    /**
     * delete post image from storage
     * @return void
     */
    public function deleteImage() {
        Storage::delete($this->image);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
