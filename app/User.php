<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
	// 
    use AuthenticableTrait;
    // 

	protected $fillable =['first_name', 'last_name' , 'avatar' ,'email','password','type'];
	//

	public function belongs(){
		if($this->type == 'manager'){

			return $this->belongsTo(Manager::Class);

		}else if ($this->type == 'agent'){

			return	$this->belongsTo(Agent::Class);
		}
	}

	public function isManager(){
		if($this->type == 'manager'){
			return true;
		}else{
			return false;
		}
	}
}
