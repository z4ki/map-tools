<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
	protected $cast =['plan' =>'array'];
    protected $fillable =['plan', 'user_id','project_id'];
}
