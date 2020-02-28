<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\Category;
	use App\Models\Admin\Site\Page;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Str;

	class PagesController extends Controller
	{

		/**
		 * Pages Welcome Page
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Exception
		 */
		public function welcome()
		{
			$pages = (new Page)->where('language', session('masterLanguage'))->get();

			return view('admin.modules.SiteModules.Pages.Pages.index')->with('pages', $pages);
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \Exception
		 */
		public function index()
		{
			return view('admin.modules.SiteModules.Pages.index');
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{

			$categories = Category::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();
			$result = nestable($categories)->attr(['name' => 'parent_id', 'class' => 'form-control', 'required' => 'required'])->renderAsDropDown();

			return view('admin.modules.SiteModules.Pages.Pages.create')->with('categories', $result);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'parent_id' => 'required',
				'name'      => 'required',
				'content'   => 'required',
				'status'    => 'required'
			]);

			$page = new Page();

			$page->parent_id = $request->input('parent_id');
			$page->name = $request->input('name');
			$page->slug = Str::slug($request->input('name'), '-');
			$page->section_url = $request->input('section_url');
			$page->content = $request->input('content');
			$page->seo_desc = $request->input('seo_desc');
			$page->seo_keywords = $request->input('seo_keywords');
			$page->sorting = $request->input('sorting');
			$page->language = session('masterLanguage');
			$page->status = $request->input('status');

			$result = $page->save();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param Page $page
		 * @return void
		 */
		public function show(Page $page)
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
			$page = (new Page)->findorFail($id);

			$categories = Category::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();

			$result = nestable($categories)
				->attr(['name' => 'parent_id', 'class' => 'form-control', 'required' => 'required'])
				->selected($page->parent_id)
				->renderAsDropDown();

			return view('admin.modules.SiteModules.Pages.Pages.edit')->with(['page' => $page, 'categories' => $result]);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param                          $id
		 * @return void
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function update(Request $request, $id)
		{

			$this->validate($request, [
				'parent_id' => 'required',
				'name'      => 'required',
				'content'   => 'required',
				'status'    => 'required'
			]);

			$page = (new Page)->findorFail($id);

			$page->parent_id = $request->input('parent_id');
			$page->name = $request->input('name');
			$page->slug = Str::slug($request->input('name'), '-');
			$page->section_url = $request->input('section_url');
			$page->content = $request->input('content');
			$page->seo_desc = $request->input('seo_desc');
			$page->seo_keywords = $request->input('seo_keywords');
			$page->sorting = $request->input('sorting');
			$page->language = session('masterLanguage');
			$page->status = $request->input('status');

			$result = $page->save();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik güncelleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @return void
		 * @throws \Exception
		 */
		public function destroy($id)
		{
			$page = (new Page)->findorFail($id);

			$result = $page->delete();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik silme hatası. Lütfen tekrar deneyiniz.');
			}
		}

	}
