<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\Notice;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Str;

	class NoticesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$news = (new Notice)->where('language', session('masterLanguage'))->get();

			return view('admin.modules.SiteModules.News.index')->with('news', $news);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			return view('admin.modules.SiteModules.News.create');
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
				'subject' => 'required',
				'content' => 'required',
				'status'  => 'required'
			]);

			$news = new Notice();

			$news->subject = $request->input('subject');
			$news->content = $request->input('content');
			$news->status = $request->input('status');
			$news->slug = Str::slug($request->input('subject'), '-');
			$news->language = session('masterLanguage');

			$result = $news->save();

			if ($result > 0) {
				return redirect('admin/news')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/news')->with('error', 'Duyuru ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param \App\Notice $notice
		 * @return \Illuminate\Http\Response
		 */
		public function show(Notice $notice)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param $id
		 * @return void
		 */
		public function edit($id)
		{
			$news = (new Notice)->findorFail($id);

			return view('admin.modules.SiteModules.News.edit')->with('news', $news);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param                          $id
		 * @return void
		 */
		public function update(Request $request, $id)
		{

			$this->validate($request, [
				'subject' => 'required',
				'content' => 'required',
				'status'  => 'required'
			]);

			$news = (new Notice)->findorFail($id);

			$news->subject = $request->input('subject');
			$news->content = $request->input('content');
			$news->status = $request->input('status');
			$news->slug = Str::slug($request->input('subject'), '-');

			$result = $news->save();

			if ($result > 0) {
				return redirect('admin/news')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/news')->with('error', 'Duyuru düzenleme hatası. Lütfen tekrar deneyiniz.');
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
			$news = (new Notice)->findorFail($id);

			$result = $news->delete();

			if ($result > 0) {
				return redirect('admin/news')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/news')->with('error', 'Duyuru silme hatası. Lütfen tekrar deneyiniz.');
			}
		}
	}
