<?php
namespace App\Http\Controllers\Admin;
use App\Product;
use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use up;
use Storage;

class ProductsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ProductsDatatable $Product) {
		return $Product->render('admin.products.index', ['title' => trans('admin.country')]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.products.create', ['title' => trans('admin.create_Product')]);
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
				'country_name_ar'     => 'required',
				'country_name_en'     => 'required',
				'mob'     => 'required',
				'code'     => 'required',
				'logo'     => 'required|'.v_image(),

			], [], [
				'country_name_ar'     => trans('admin.country_name_ar'),
				'country_name_en'    => trans('admin.country_name_en'),
				'mob' => trans('admin.mob'),
				'code' => trans('admin.code'),
				'logo' => trans('admin.logo'),
			]);
		$data['country_name_ar'] = request('country_name_ar');
		$data['country_name_en'] = request('country_name_en');
		$data['mob'] = request('mob');
		$data['code'] = request('code');
		$data['logo'] = request('logo');
		if (request()->hasFile('logo')) {
    	
    			$data['logo'] = Up::upload([
                    //'new_name' =>'',
                    'file'     =>'logo',
                    'path'      =>'products',
                    'upload_type'=>'single',
                    'delete_file'=>'',
                ]);
    	
    	}
		Product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
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
		$Product = Product::find($id);
		$title = trans('admin.edit');
		return view('admin.products.edit', compact('Product', 'title'));
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
				'country_name_ar'    => 'required',
				'country_name_en'    => 'required',
				'mob'    			 => 'required',
				'code'    			 => 'required',
				'logo'     			 => 'sometimes|nullable|'.v_image(),

			], [], [
				'country_name_ar'     => trans('admin.country_name_ar'),
				'country_name_en'  	  => trans('admin.country_name_en'),
				'mob' => trans('admin.mob'),
				'code' => trans('admin.code'),
				'logo' => trans('admin.logo'),
			]);
		$data['country_name_ar'] = request('country_name_ar');
		$data['country_name_en'] = request('country_name_en');
		$data['mob'] = request('mob');
		$data['code'] = request('code');
		$data['logo'] = request('logo');

		if (request()->hasFile('logo')) {
    		if(!empty(setting()->logo)){
    			$data['logo'] = Up::upload([
                    //'new_name' =>'',
                    'file'     =>'logo',
                    'path'      =>'products',
                    'upload_type'=>'single',
                    'delete_file'=>Product::find($id)->logo,
                ]);
    		}
    	}

		Product::where('id',$id)->update($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$country = Product::find($id);
		Storage::delete($country->logo);
		$country->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
	public function multi_delete() {

		if (is_array(request('item'))) {
			foreach (request('item') as $id ) {
				$country = Product::find($id);
				Storage::delete($country->logo);
				$country->delete();
			}
		} else {
			$country = Product::find(request('item'));
				Storage::delete($country->logo);
				$country->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
}
