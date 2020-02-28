<?php

	namespace App\Http\Controllers\Admin;

	use App\Http\Controllers\Controller;

	class HomeController extends Controller
	{

		/**
		 * Show the application dashboard.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			return view('admin.dashboard.home');
		}

		/**
		 * Change Panel Language
		 *
		 * @param $iso
		 * @return
		 */
		public function changeLanguage($iso)
		{
			session(['masterLanguage' => $iso]);

			return redirect()->back();
		}
	}
