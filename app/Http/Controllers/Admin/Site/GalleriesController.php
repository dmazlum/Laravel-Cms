<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\AdminSetup;
	use App\Models\Admin\Site\Gallery;
	use App\Models\Admin\Site\GalleryCategory;
	use App\Models\Admin\Site\Page;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\File;
	use Intervention\Image\Facades\Image;

	class GalleriesController extends Controller
	{

		/**
		 * Pages Welcome Page
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Exception
		 */
		public function welcome()
		{
			$categories = GalleryCategory::where('parent_id', NULL)->get();

			return view('admin.modules.SiteModules.Gallery.Galleries.index')->with('categories', $categories);
		}

		/**
		 * List Sub Categories
		 *
		 * @param $id
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Exception
		 */
		public function listcategory($id)
		{

			$checkSubCategory = GalleryCategory::where('parent_id', $id)->get();
			$categoryName = GalleryCategory::where('id', $id)->get();

			// Get All Photos from gallery
			$gallery = Gallery::where('parent_id', $id)->get();

			return view('admin.modules.SiteModules.Gallery.Galleries.index')
				->with(['categories' => $checkSubCategory, 'categoryName' => $categoryName, 'gallery' => $gallery]);
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \Exception
		 */
		public function index()
		{
			return view('admin.modules.SiteModules.Gallery.index');
		}

		/**
		 * Create Gallery Photo
		 *
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 * @throws \Exception
		 */
		public function create()
		{
			$urlToId = url()->previous();
			$id = substr($urlToId, -1);

			$categoryName = GalleryCategory::where('id', $id)->get();

			return view('admin.modules.SiteModules.Gallery.Galleries.create')->with(['categoryName' => $categoryName, 'backUrl' => url()->previous()]);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 */
		public function store(Request $request)
		{

			$this->validate($request, [
				'catId' => 'required',
			]);

			$field = $request->input();
			$thumbSize = (new AdminSetup)->where('config_name', 'site_thumbnail')->get()->toArray();
			$thumbSize = explode('x', $thumbSize[0]['config_value']);
			$gallery = new Gallery();

			if ($request->hasfile('file')) {

				$file = $request->file('file');

				//Upload Path
				$path = public_path() . '/uploads/gallery/' . $field['path'];

				// If the Thumbnail path does not exist, create it.
				$thumbPath = public_path() . '/uploads/gallery/' . $field['path'] . '/thumbnail';

				if (!File::exists($thumbPath)) {
					File::makeDirectory($thumbPath, $mode = 0777, true, true);
				}

				//foreach ($request->file('file') as $file) {

				$gallery->parent_id = $field['catId'];
				$gallery->sorting = $field['key'];

				$gallery->name = time() . '-' . $file->getClientOriginalName();

				// Thumbnail
				$img = Image::make($file->getRealPath());
				$img->resize($thumbSize[0], $thumbSize[1], function ($constraint) {
					$constraint->aspectRatio();
				})->save($thumbPath . '/' . $gallery->name);

				$file->move($path, $gallery->name);
				$data[] = $gallery->name;

				//}
			}

			$gallery->status = 1;

			$result = $gallery->save();

			if ($result > 0) {
				echo json_encode(array('data' => 'ok'));
			} else {
				echo json_encode(array('data' => 'error'));
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
			$page = (new Gallery)->findorFail($id);

			$categories = GalleryCategory::nested()
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
		 */
		public function update(Request $request, $id)
		{

			$this->validate($request, [
				'parent_id' => 'required',
				'name'      => 'required',
				'content'   => 'required',
				'status'    => 'required'
			]);

			$page = (new Gallery)->findorFail($id);

			$page->parent_id = $request->input('parent_id');
			$page->name = $request->input('name');
			$page->sorting = $request->input('sorting');
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
			$page = (new Gallery)->findorFail($id);

			$result = $page->delete();

			if ($result > 0) {
				return redirect('admin/pages/welcome')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/pages/welcome')->with('error', 'İçerik silme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Delete Gallery Photos
		 *
		 * @param Request $request
		 * @throws \Exception
		 */
		public function deleteGalleryPhotos(Request $request)
		{

			$this->validate($request, [
				'deleteData' => 'required',
			]);

			$count = count($request->deleteData);

			$i = 0;
			foreach ($request->deleteData as $data) {

				$photo = Gallery::findOrFail($data['id']);
				$photo->delete();

				// Delete photo
				File::delete(public_path() . '/uploads/gallery/' . $data['path']);

				// Delete Thumbnail
				File::delete(public_path() . '/uploads/gallery/' . $data['thumb']);

				$i = $i + 1;
			}

			if ($i == $count) {
				echo 'redirect';
			}

		}

	}
