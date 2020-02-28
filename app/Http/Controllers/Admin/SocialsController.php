<?php

	namespace App\Http\Controllers\Admin;

	use App\Models\Admin\Social;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;

	class SocialsController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return void
		 */
		public function index()
		{
			$social = Social::all();

			return view('admin.modules.Socials.index')->with('socials', $social);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			return view('admin.modules.Socials.create');
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'social_name' => 'required',
				'social_url'  => 'required',
				'icon'        => 'required',
				'status'      => 'required'
			]);

			$social = new Social();

			$social->social_name = $request->input('social_name');
			$social->social_url = $request->input('social_url');
			$social->icon = $request->input('icon');
			$social->status = $request->input('status');

			$result = $social->save();

			if ($result > 0) {
				return redirect('admin/socials')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/socials')->with('error', 'Kayıt ekleme hatası. Lütfen tekrar deneyiniz');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param \App\Social $social
		 * @return \Illuminate\Http\Response
		 */
		public function show(Social $social)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			$social = Social::find($id);

			return view('admin.modules.Socials.edit')->with('social', $social);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param Social                   $social
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Social $social)
		{
			$this->validate($request, [
				'social_name' => 'required',
				'social_url'  => 'required',
				'icon'        => 'required',
				'status'      => 'required'
			]);

			$social->social_name = $request->input('social_name');
			$social->social_url = $request->input('social_url');
			$social->icon = $request->input('icon');
			$social->status = $request->input('status');

			$result = $social->save();

			if ($result > 0) {
				return redirect('admin/socials')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/socials')->with('error', 'Kayıt ekleme hatası. Lütfen tekrar deneyiniz');
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @return \Illuminate\Http\Response
		 * @throws \Exception
		 */
		public function destroy($id)
		{
			$social = Social::find($id);

			$result = $social->delete();

			if ($result > 0) {
				return redirect('admin/socials')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/socials')->with('error', 'Kayıt silme hatası. Lütfen tekrar deneyiniz');
			}
		}
	}
