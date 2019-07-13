<?php
namespace App\Http\Controllers\Admin;
use App\User;
use App\DataTables\UsersDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UsersController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(UsersDatatable $admin) {
		return $admin->render('admin.users.index', ['title' => 'Users Control']);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.users.create', ['title' => trans('admin.create')]);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store() {
		$data = $this->validate(request(),
			[
				'name'     => 'required',
				'email'    => 'required|email|unique:users',
				'level'		=> 'required|in:user,company,vendor',
				'password' => 'required|min:6'
			], [], [
				'name'     => trans('name'),
				'email'    => trans('email'),
				'level'    => trans('level'),
				'password' => trans('password'),
			]);
		$data['password'] = bcrypt(request('password'));
		$data['email'] = request('email');
		$data['name'] = request('name');
		$data['level'] = request('level');
		User::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('users'));
		//return $data;
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$user = User::find($id);
		$title = trans('admin.edit');
		return view('admin.users.edit', compact('user', 'title'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $r, $id) {
		$data = $this->validate(request(),
			[
				'name'     => 'required|min:6',
				'email'    => 'required|email|unique:users,email,'.$id,
				'level'		=> 'required|in:user,company,vendor',
				'password' => 'sometimes|nullable|min:6'
			], [], [
				'name'     => trans('admin.name'),
				'email'    => trans('admin.email'),
				'level'    => trans('level'),
				'password' => trans('admin.password'),
			]);
		if (request()->has('password')) {
			$data['password'] = bcrypt(request('password'));
		}
		$data['email'] = request('email');
		$data['name'] = request('name');
		$data['level'] = request('level');
		User::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('users'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		User::find($id)->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('users'));
	}
	public function multi_delete() {
		if (is_array(request('item'))) {
			User::destroy(request('item'));
		} else {
			User::find(request('item'))->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('users'));
	}
}
