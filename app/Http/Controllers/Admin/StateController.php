<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\StateDatatable;
use App\Http\Controllers\Controller;

use App\state;
use App\city;

use Illuminate\Http\Request;

class StateController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(StateDatatable $state) {
		return $state->render('admin.states.index', ['title' => trans('admin.states')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.states.create', ['title' => trans('admin.create_state')]);
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
				'state_name_ar' => 'required',
				'state_name_en' => 'required',
				'city_id'   	=> 'required|numeric',
				'country_id'   => 'required|numeric',

			], [], [
				'state_name_ar' => trans('admin.State_name_ar'),
				'state_name_en' => trans('admin.State_name_en'),
				'city_id'   => trans('admin.city_id'),
				'country_id'   => trans('admin.country_id'),

			]);
		$data['state_name_ar'] = request('state_name_ar');
		$data['state_name_en'] = request('state_name_en');
		$data['city_id'] = request('city_id');
		$data['country_id'] = request('country_id');

		state::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('states'));
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
		$state = State::find($id);
		$title   = trans('admin.edit');
		return view('admin.states.edit', compact('state', 'title'));
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
				'state_name_ar' => 'required',
				'state_name_en' => 'required',
				'city_id'   => 'required|numeric',
				'country_id'   => 'required|numeric',

			], [], [
				'state_name_ar' => trans('admin.State_name_ar'),
				'state_name_en' => trans('admin.State_name_en'),
				'city_id'   => trans('admin.city_id'),
				'country_id'   => trans('admin.country_id'),

			]);
		$data['state_name_ar'] = request('state_name_ar');
		$data['state_name_en'] = request('state_name_en');
		$data['city_id'] = request('city_id');
		$data['country_id'] = request('country_id');

		state::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('states'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$state = state::find($id);

		$state->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('states'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$state = State::find($id);
				$state->delete();
			}
		} else {
			$state = State::find(request('item'));
			$state->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('states'));
	}
}
