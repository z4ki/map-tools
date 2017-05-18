<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
	// 
	protected $fillable = ['manager_id','user_id'];
    //
    public function myManager(){
    	$this->belongsTo(Manager::Class);
    }

    public function myCredentials(){
    	$this->hasOne(User::Class);
    }
}
