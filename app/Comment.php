<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gallery;

class Comment extends Model
{
    protected $fillable = ['text'];

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }
}
