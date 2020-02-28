<?php

	namespace App\Http\Controllers\Admin;

	use App\Http\Controllers\Controller;
	use App\Models\Admin\Language;

	class LanguagesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return void
		 */
		public function index()
		{
			$languages = Language::all();

			return view('admin.modules.Languages.index')->with('languages', $languages);
		}

		/**
		 * Edit Languages
		 *
		 * @param $id
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function edit($id)
		{
			$language = Language::find($id);

			if ($language->status == 1) {
				$language->status = 0;
			} else {
				$language->status = 1;
			}

			$status = $language->save();

			if ($status > 0) {
				return redirect('admin/languages')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/languages')->with('error', 'Dil durumu değiştirilmedi.');
			}
		}
	}
