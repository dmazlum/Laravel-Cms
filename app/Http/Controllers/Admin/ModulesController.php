<?php

	namespace App\Http\Controllers\Admin;

	use App\Models\Admin\Module;
	use Illuminate\Http\RedirectResponse;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;

	class ModulesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 */
		public function index()
		{
			$data = Module::all();

			return view('admin.modules.Modules.index')->with('modules', $data);
		}


		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param Module $module
		 * @return RedirectResponse
		 */
		public function edit(Module $module)
		{
			$mod = (new Module)->find($module->id);

			if ($mod->status == 1) {
				$mod->status = 0;
			} else {
				$mod->status = 1;
			}

			$status = $mod->save();

			if ($status > 0) {
				return redirect('admin/modules')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/modules')->with('error', 'Modul durumu değiştirilemedi.');
			}
		}
	}
