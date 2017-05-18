<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
	// 
	protected $fillabale = ['user_id'];
    //
    public function myAgents(){
     	return $this->hasMany(Agent::Class,'manager_id','user_id');
    }

    public function myCredentials(){
    	return $this->hasOne(User::Class);
    }

}
