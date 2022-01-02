<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function languages(){
        return $this->belongsTo(Language::class, 'language_id');
    }

}
