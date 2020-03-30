<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['title', 'description'];

    public function files()
    {
        return $this->belongsToMany('App\File');
    }
}
