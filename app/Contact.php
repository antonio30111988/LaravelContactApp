<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','birth_date'];
	
	/**
     * Get age from birth_date field
     *
     * @var string
     */
	public function age() 
	{
		return $this->birth_date->diffInYears(Carbon::now());
	}

	/**
     * Update Validation rules
     *
     * @var array
     */
	public static function updateRequestRules ($id=0, $extend=[]) 
	{
		return array_merge(
			[
				'name' => 'required|string|max:100|unique:contacts,name' . ($id ? ",$id" : ''),
				'nick_name' => 'nullable|max:50',
				'gender' => 'nullable|max:1',
				'email' => 'required|email|unique:contacts'. ($id ? ",id,$id" : ''),
				'phone' => 'required|numeric|phone_number',
				'address' => 'required|alpha_num_space',
				'company' => 'required',
				'birth_date' => 'present|date|before_or_equal:today'
			], 
			$extend);
	}	
}
