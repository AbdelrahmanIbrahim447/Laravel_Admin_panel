<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    protected $table = 'file';
    protected $fillable = [
    	'name',
    	'file',
    	'size',
    	'path',
    	'full_file',
    	'mime_type',
    	'file_type',
    	'relation_id',

    ];
}
