<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Department;
use Illuminate\Http\Request;
use up;
use Storage;
class DepartmentsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('admin.departments.index', ['title' => trans('admin.departments')]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.departments.create', ['title' => trans('admin.create_departments')]);
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
				'dep_name_ar' => 'required',
				'dep_name_en' => 'required',
				'icon' => 'sometimes|nullable|'. v_image(),
				'descreption' => 'sometimes|nullable',
				'keyword' => 'sometimes|nullable',
				'parent_id' => 'sometimes|nullable|numeric',

			], [], [

				'dep_name_ar'	 	=> trans('admin.dep_name_ar'),
				'dep_name_en' 		 => trans('admin.dep_name_en'),
				'icon' 			   	=> trans('admin.icon'),
				'descreption'		 =>trans('admin.descreption'),
				'keyword' 			=> trans('admin.keyword'),
				'parent_id'	 		=>trans('admin.parent_id'),

			]);

	
		
		if (request()->hasFile('icon')) {
    	
    			$data['icon'] = up::upload([
          
                    'file'     =>'icon',
                    'path'      =>'departments',
                    'upload_type'=>'single',
                    'delete_file'=>Department::find(request()->icon),
                ]);
    	
    	}

		Department::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('departments'));
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
		$department = Department::find($id);
		$title   = trans('admin.edit');
		return view('admin.departments.edit', compact('department', 'title'));
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
				'dep_name_ar' => 'required',
				'dep_name_en' => 'required',
				'icon' => 'sometimes|nullable|' . v_image(),
				'descreption' => 'sometimes|nullable',
				'keyword' => 'sometimes|nullable',
				'parent_id' => 'sometimes|nullable|numeric',

			], [], [

				'dep_name_ar'	 	=> trans('admin.dep_name_ar'),
				'dep_name_en' 		 => trans('admin.dep_name_en'),
				'icon' 			   	=> trans('admin.icon'),
				'descreption'		 =>trans('admin.descreption'),
				'keyword' 			=> trans('admin.keyword'),
				'parent_id'	 		=>trans('admin.parent_id'),

			]);
    	
		
		if (request()->hasFile('icon')) {
    	
    			$data['icon'] = up::upload([
          
                    'file'     =>'icon',
                    'path'      =>'departments',
                    'upload_type'=>'single',
                    'delete_file'=>Department::find($id)->icon,
                ]);
    	
    	}
		Department::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('departments'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public static function delete_parent($id){
		$department_parent = Department::where('parent_id',$id)->get();
		foreach ($department_parent as $sub ) {
			self::delete_parent($sub->id);
			if (!empty($sub->icon)) {
				 \Storage::has($sub->icon)?\Storage()::delete($sub->icon):'';
			}
			$sub_dep = Department::find($sub->id);
			if (!empty($sub_dep)) {
				$sub_dep->delete();
			}
		}
			$dep = Department::find($id);
		if (!empty($dep->icon)) {
				 \Storage::has($dep->icon)?\Storage::delete($dep->icon):'';
			}
			$dep->delete();

	}
	public function destroy($id) {
		$Department = Department::find($id);
		self::delete_parent($id);
		$Department->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('departments'));
	}


}

