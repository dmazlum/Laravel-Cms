<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\Category;
	use Exception;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;

	class CategoriesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 * @throws Exception
		 */
		public function index()
		{
			$items = Category::where(['language' => session('masterLanguage')])->orderBy('sorting', 'asc')->get();
			$menu = new Category();
			$menu = $menu->getHTML($items);

			return view('admin.modules.SiteModules.Pages.Category.index')->with('menu', $menu);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return Response
		 */
		public function create()
		{
			$categories = Category::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();
			$result = nestable($categories)->attr(['name' => 'page_id', 'class' => 'form-control'])->renderAsDropDown();

			return view('admin.modules.SiteModules.Pages.Category.create')->with('categories', $result);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 * @return Response
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'name'   => 'required',
				'status' => 'required'
			]);

			$category = new Category();

			$category->name = $request->input('name');

			// is null?
			if ($request->input('page_id') != '') {
				$category->parent_id = $request->input('page_id');
			} else {
				$category->parent_id = NULL;
			}

			$category->language = session('masterLanguage');
			$category->status = $request->input('status');

			$result = $category->save();

			if ($result > 0) {
				return redirect('admin/categories')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/categories')->with('error', 'Kategori ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param Category $category
		 * @return void
		 */
		public function show(Category $category)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param $id
		 * @return Response
		 */
		public function edit($id)
		{
			$category = Category::find($id);

			if ($category) {
				return view('admin.modules.SiteModules.Pages.Category.edit')->with('category', $category);
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param         $id
		 * @return void
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'name'   => 'required',
				'status' => 'required'
			]);

			$category = Category::find($id);

			$category->name = $request->input('name');
			$category->status = $request->input('status');

			$result = $category->save();

			if ($result > 0) {
				return redirect('admin/categories')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/categories')->with('error', 'Kategori güncelleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @return void
		 * @throws Exception
		 */
		public function destroy($id)
		{
			// Check Content belong this category
			$checkContent = (new Category)->find($id)->pages()->get();

			if ($checkContent->count() > 0) {
				return redirect('admin/categories')->with('error', 'Bu Kategori altında içerik olduğundan dolayı silinememektedir. Lütfen içerikleri silip tekrar deneyiniz.');
			} else {

				$category = Category::find($id);
				$result = $category->delete();

				if ($result > 0) {
					return redirect('admin/categories')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
				} else {
					return redirect('admin/categories')->with('error', 'Kategori silme hatası. Lütfen tekrar deneyiniz.');
				}
			}
		}

		/**
		 * Change Menu Order
		 *
		 * @param Request $request
		 * @return string
		 */
		public function changeMenuOrder(Request $request)
		{
			$source = e($request->input('source'));
			$destination = e($request->input('destination'));
			$item = (new Category())->find($source);
			$item->parent_id = $destination;
			$item->save();

			$ordering = json_decode($request->input('order'));
			$rootOrdering = json_decode($request->input('rootOrder'));

			if ($ordering) {
				foreach ($ordering as $order => $item_id) {
					if ($itemToOrder = Category::find($item_id)) {
						$itemToOrder->sorting = $order;
						$itemToOrder->save();
					}
				}
			} else {
				foreach ($rootOrdering as $order => $item_id) {
					if ($itemToOrder = Category::find($item_id)) {
						$itemToOrder->sorting = $order;
						$itemToOrder->save();
					}
				}
			}

			return 'ok ';
		}
	}
