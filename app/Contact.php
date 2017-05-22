<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use SoftDeletes;
	
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [
        'name','nick_name', 'phone','address','email', 'company','birth_date','gender'
    ]; 

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
    protected $hidden = [
        //'password', 'remember_token',
    ];
	
	/**
	* Get the user that owns the contact.
	*/
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
