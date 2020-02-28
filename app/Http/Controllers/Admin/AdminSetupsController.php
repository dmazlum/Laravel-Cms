<?php

	namespace App\Http\Controllers\Admin;

	use App\Models\Admin\AdminSetup;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;

	class AdminSetupsController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 */
		public function index()
		{
			$setup = AdminSetup::all();

			return view('admin.modules.Setup.index')->with('setups', $setup);
		}


		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @return void
		 */
		public function update(Request $request)
		{

			foreach ($request->input() as $key => $value) {
				if ($key != '_token') {
					(new AdminSetup)->where('config_name', $key)->update(['config_value' => $value]);
				}
			}

			return redirect('admin/setup')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
		}

	}
