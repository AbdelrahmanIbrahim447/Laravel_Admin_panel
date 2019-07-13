<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use DB;
use Mail;
class AdminAuth extends Controller
{
    public function login(){
    	if(auth('admin')->check()){return redirect('admin');}else{return view('admin.login');}
    	
    }

    public function dologin(){
    	$remember = request('rememberme') == 1 ? true : false; 
    	if (auth()->guard('admin')->attempt(['email'=>request('email'),'password'=>request('password')] , $remember)) {
    		
    		return redirect('admin');
    	}
    	else {
    		session()->flash('error',trans('admin.error_in_login'));
    		return redirect('admin/login');
    	}
    }
    public function logout(){
    	auth()->guard('admin')->logout();
    	return redirect('admin/login');
    }
    public function reset_password(){
    	return view('admin.reset_password');
    }
    public function reset_password_post() {
		$admin = Admin::where('email', request('email'))->first();
		if (!empty($admin)) {
			$token = app('auth.password.broker')->createToken($admin);
			$data  = DB::table('password_resets')->insert([
					'email'      => $admin->email,
					'token'      => $token,
					'created_at' => Carbon::now(),
				]);
			Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin, 'token' => $token]));
			session()->flash('success', trans('admin.the_link_reset_sent'));
			return back();
		}
		return back();
	}
	public function forgot_password($token){
		$check_token = DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()->subHours(1))->first();
		if(!empty($check_token)){
			return view('admin.forget_password');
		}else{
			return redirect('admin/forget/password');
		}
	}
	public function forgot_password_final($token){
		$this->validate(request(),[
			'password' => 'required|confirmed',
			'password_confirmation'=> 'required'
		],[],[
			'password'=>'password',
			'passwordConfirm'=> 'password Confirmation'
		]);
		$check_token = DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()->subHours(1))->first();
		if(!empty($check_token)){

			$admin = Admin::where('email',$check_token->email)->update(['email'=>$check_token->email , 'password'=> bcrypt(request('password'))]);
			DB::table('password_resets')->where('email',$check_token->email)->delete();
			auth()->guard('admin')->attempt(['email'=>$check_token->email,'password'=>request('password')] , true);
			return redirect('admin');
		}else{
			return redirect('admin/reset/password');
		}
	}
}
