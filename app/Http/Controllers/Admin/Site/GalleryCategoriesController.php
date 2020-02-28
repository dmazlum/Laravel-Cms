<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\Category;
	use App\Models\Admin\Site\GalleryCategory;
	use Exception;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Str;

	class GalleryCategoriesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 * @throws Exception
		 */
		public function index()
		{
			$items = GalleryCategory::where(['language' => session('masterLanguage')])->orderBy('sorting', 'asc')->get();
			$menu = new GalleryCategory();
			$menu = $menu->getHTML($items);

			return view('admin.modules.SiteModules.Gallery.Category.index')->with('menu', $menu);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return Response
		 */
		public function create()
		{
			$categories = GalleryCategory::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();
			$result = nestable($categories)->attr(['name' => 'parent_id', 'class' => 'form-control'])->renderAsDropDown();

			return view('admin.modules.SiteModules.Gallery.Category.create')->with('categories', $result);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 * @return Response
		 */
		public function store(Request $request)
		{

			$this->validate($request, [
				'name'   => 'required',
				'status' => 'required'
			]);

			$category = new GalleryCategory();

			$category->name = $request->input('name');
			$category->slug = Str::slug($request->input('name'), '-');
			$category->content = $request->input('content');
			$category->sorting = $request->input('sorting');

			// is null?
			if ($request->input('parent_id') != '') {
				$category->parent_id = $request->input('parent_id');
			} else {
				$category->parent_id = NULL;
			}

			// Create Directory
			$path = public_path() . '/uploads/gallery/' . Str::slug($request->input('name'), '-');
			File::makeDirectory($path, $mode = 0777, true, true);

			// Check Image
			if ($request->file) {
				$file = $request->file('file');
				$fileName = time() . '-' . $file->getClientOriginalName();
				$category->photo = $fileName;

				$file->move($path, $fileName);
			}

			$category->language = session('masterLanguage');
			$category->status = $request->input('status');

			$result = $category->save();

			if ($result > 0) {
				return redirect('admin/gallery/galleryCategory')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/gallery/galleryCategory')->with('error', 'Kategori ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Display the specified resource.
		 *
		 * @param \App\Category $category
		 * @return Response
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
			$category = GalleryCategory::find($id);

			$categories = GalleryCategory::nested()
				->where(['status' => 1, 'language' => session('masterLanguage')])
				->orderBy('sorting', 'asc')
				->get()
				->toArray();
			$result = nestable($categories)
				->attr(['name' => 'parent_id', 'class' => 'form-control'])
				->selected($category->id)
				->renderAsDropDown();

			if ($category) {
				return view('admin.modules.SiteModules.Gallery.Category.edit')->with(['category' => $category, 'categories' => $result]);
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param         $id
		 * @return void
		 */
		public function update(Request $request, $id)
		{

			$this->validate($request, [
				'name'   => 'required',
				'status' => 'required'
			]);

			$category = GalleryCategory::find($id);

			// Create Directory
			$path = public_path() . '/uploads/gallery/' . $category->slug;

			if ($category->slug !== Str::slug($request->input('name'), '-')) {

				//Create New Folder
				$path = public_path() . '/uploads/gallery/' . Str::slug($request->input('name'), '-');
				File::makeDirectory($path, $mode = 0777, true, true);

				//Move file if has one?
				if ($category->photo != '') {
					File::move(public_path() . '/uploads/gallery/' . $category->slug . '/' . $category->photo, $path . '/' . $category->photo);
				}

				// Delete Old folder
				File::deleteDirectory(public_path() . '/uploads/gallery/' . $category->slug);
			}

			$category->name = $request->input('name');
			$category->slug = Str::slug($request->input('name'), '-');
			$category->content = $request->input('content');
			$category->sorting = $request->input('sorting');
			$category->status = $request->input('status');

			// Check Image
			if ($request->file) {

				$file = $request->file('file');
				$fileName = time() . '-' . $file->getClientOriginalName();
				$category->photo = $fileName;

				$file->move($path, $fileName);
			}

			$result = $category->save();

			if ($result > 0) {
				redirect('admin/gallery/galleryCategory')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				redirect('admin/gallery/galleryCategory')->with('error', 'Kategori güncelleme hatası. Lütfen tekrar deneyiniz.');
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
			$checkContent = (new GalleryCategory)->find($id)->pages()->get();

			if ($checkContent->count() > 0) {
				redirect('admin/gallery/galleryCategory')->with('error', 'Bu Kategori altında içerik olduğundan dolayı silinememektedir. Lütfen içerikleri silip tekrar deneyiniz.');
			} else {

				$category = GalleryCategory::find($id);
				$result = $category->delete();

				if ($result > 0) {
					redirect('admin/gallery/galleryCategory')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
				} else {
					redirect('admin/gallery/galleryCategory')->with('error', 'Kategori silme hatası. Lütfen tekrar deneyiniz.');
				}
			}
		}

		/**
		 * Delete Category Photo
		 *
		 * @param Request $request
		 * @return string
		 */
		public function deleteSinglePhoto(Request $request)
		{
			if ($request->key) {
				$photo = (new GalleryCategory)->findOrFail($request->key);

				//Delete Photo in folder
				$path = public_path() . '/uploads/gallery/' . $photo->slug . '/';
				File::delete($path . $photo->photo);

				$photo->photo = '';
				$photo->save();
			}

			return '{}';
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
			$item = (new GalleryCategory())->find($source);
			$item->parent_id = $destination;
			$item->save();

			$ordering = json_decode($request->input('order'));
			$rootOrdering = json_decode($request->input('rootOrder'));

			if ($ordering) {
				foreach ($ordering as $order => $item_id) {
					if ($itemToOrder = GalleryCategory::find($item_id)) {
						$itemToOrder->sorting = $order;
						$itemToOrder->save();
					}
				}
			} else {
				foreach ($rootOrdering as $order => $item_id) {
					if ($itemToOrder = GalleryCategory::find($item_id)) {
						$itemToOrder->sorting = $order;
						$itemToOrder->save();
					}
				}
			}

			return 'ok ';
		}
	}
