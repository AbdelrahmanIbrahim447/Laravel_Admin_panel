<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
// use App\file;
class upload extends Controller
{
    public static function upload($data=[]){
    	if(in_array('new_name',$data)){
    		$new_name =$data['new_name'] === null ?time(): $data['new_name'];
    	}
    		
    	if (request()->hasFile($data['file']) && $data['upload_type'] == 'single') {
    		if(Storage::has($data['delete_file']))
    		{
    		
    		 Storage::delete($data['delete_file']);
            }
    		return request()->file($data['file'])->store($data['path']);
    	}
    }
}
 //////////////////////////////////////////////////////////////////////////////////////////// prpblem !!!!!!!!!!!