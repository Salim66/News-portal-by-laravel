<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function languages(){
        return $this->belongsTo(Language::class, 'language_id');
    }

    // get post tag wise
    public function posts(){
        return $this->belongsToMany('App\Models\Post');
    }

}
