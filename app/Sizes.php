<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
   protected $table    = 'sizes';
   protected $fillable = [
      'name_ar',
      'name_en',
      'department_id',
      'is_public',
   ];

   public function department_id(){

   	return $this->hasOne('App\Department','id','department_id');
   }
}
