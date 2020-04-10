<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['name', 'review'];

    public function files()
    {
        return $this->belongsToMany('App\File');
    }
}
