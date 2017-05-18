<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //
    protected $cast = ['map' =>'array'];
    protected $fillable = ['map', 'user_id','project_id','project_name','description','state','screenshot'];
}
