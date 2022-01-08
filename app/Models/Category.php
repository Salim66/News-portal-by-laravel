<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


    // get child category
    public function categories(){
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function languages(){
        return $this->belongsTo(Language::class, 'language_id');
    }

    // get category wise post
    public function posts(){
        return $this->belongsToMany('App\Models\Post');
    }

}
