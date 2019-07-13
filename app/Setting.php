<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Up;
class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
    	'sitename_ar',
    	'sitename_en',
    	'logo',
    	'icon',
    	'email',
    	'description',
		'keywords',
		'status',
		'message_maintance',
		'main_lang',

    ];
}
