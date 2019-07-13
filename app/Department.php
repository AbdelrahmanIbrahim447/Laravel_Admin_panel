<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
    	'dep_name_ar',
	   	'dep_name_en',
    	'icon',
    	'descreption',
    	'keyword',
    	'parent_id',


    ];

     public function parents(){
     	return $this->hasMany('App\Departments','id','parent_id');
     }

}
