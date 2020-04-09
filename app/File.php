<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['src'];

    public function works()
    {
        return $this->belongsToMany('App\Work');
    }

}
