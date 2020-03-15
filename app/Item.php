<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['title', 'description', 'cost'];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
