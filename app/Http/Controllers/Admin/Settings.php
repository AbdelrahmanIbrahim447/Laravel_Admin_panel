<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Storage;
use up;
class Settings extends Controller
{
    public function setting(){
    	return view('admin.settings',['title'=>trans('admin.settings')]);
    }
    public function setting_save(){
    	$this->validate(request(),
    		[
    			'logo'=>v_image(),
    			'icon'=>v_image(),
                'email'=> '',
                'description'=> '',
                'keywords'=> '',
                'status'=> '',
                'message_maintance'=> '',
                'main_lang'=> '',

    		],[],
    		[
    			'logo'=>trans('admin.logo'),
    			'icon'=>trans('admin.icon'),
    		]);
    	$data = request()->except(['_token','_method']);

    	if (request()->hasFile('logo')) {
    		if(!empty(setting()->logo)){
    			$data['logo'] = Up::upload([
                    //'new_name' =>'',
                    'file'     =>'logo',
                    'path'      =>'setting',
                    'upload_type'=>'single',
                    'delete_file'=>setting()->logo,
                ]);
    		}
    	}
		if (request()->hasFile('icon')) {
    		 if(!empty(setting()->icon)){
                $data['icon'] = Up::upload([
                    //'new_name' =>'',
                    'file'     =>'icon',
                    'path'      =>'setting',
                    'upload_type'=>'single',
                    'delete_file'=>setting()->icon,
                ]);
            }
        }

    	Setting::orderBy('id','desc')->update($data);
    	session()->flash('success',trans('admin.updated_record'));
    	return redirect(aurl('settings'));
    }
}
