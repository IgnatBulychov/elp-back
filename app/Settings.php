<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  public function file()
  {
    return $this->belongsTo('App\File');
  }
}
