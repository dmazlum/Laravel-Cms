<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\ProductCategory;
	use App\Models\Admin\Site\Product;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Str;

	class ProductsController extends Controller
	{

		/**
		 * Pages Welcome Page
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Exception
		 */
		public function welcome()
		{
			$pages = (new Product)->where('language', session('masterLanguage'))->get();

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

			$categories = ProductCategory::nested()
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

			$product = new Product();

			$product->parent_id = $request->input('parent_id');
			$product->name = $request->input('name');
			$product->slug = Str::slug($request->input('name'), '-');
			$product->content = $request->input('content');
			$product->seo_desc = $request->input('seo_desc');
			$product->seo_keywords = $request->input('seo_keywords');
			$product->sorting = $request->input('sorting');
			$product->language = session('masterLanguage');
			$product->status = $request->input('status');

			$result = $product->save();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param Product $product
		 * @return void
		 */
		public function show(Product $product)
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
			$product = (new Product)->findorFail($id);

			$categories = ProductCategory::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();

			$result = nestable($categories)
				->attr(['name' => 'parent_id', 'class' => 'form-control', 'required' => 'required'])
				->selected($product->parent_id)
				->renderAsDropDown();

			return view('admin.modules.SiteModules.Pages.Pages.edit')->with(['page' => $product, 'categories' => $result]);
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

			$product = (new Product)->findorFail($id);

			$product->parent_id = $request->input('parent_id');
			$product->name = $request->input('name');
			$product->slug = Str::slug($request->input('name'), '-');
			$product->content = $request->input('content');
			$product->seo_desc = $request->input('seo_desc');
			$product->seo_keywords = $request->input('seo_keywords');
			$product->sorting = $request->input('sorting');
			$product->language = session('masterLanguage');
			$product->status = $request->input('status');

			$result = $product->save();

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
			$product = (new Product)->findorFail($id);

			$result = $product->delete();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik silme hatası. Lütfen tekrar deneyiniz.');
			}
		}

	}
