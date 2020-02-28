<?php

	namespace App\Http\Controllers\Admin\Site;

	use App\Models\Admin\Site\Category;
	use App\Models\Admin\Site\Template;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;

	class TemplatesController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 */
		public function index()
		{
			$template = Template::all();
			$categories = Category::nested()->where(['status' => 1, 'language' => session('masterLanguage')])->get()->toArray();
			$result = nestable($categories)
				->attr(['name' => 'parent_id', 'class' => 'form-control change_cat', 'required' => 'required'])
				->renderAsDropDown();

			return view('admin.modules.SiteModules.Templates.index')->with(['templates' => $template, 'categories' => $result]);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return Response
		 */
		public function create()
		{
			$categories = Category::nested()->where(['status' => 1, 'language' => session('masterLanguage')])->get()->toArray();
			$result = nestable($categories)
				->attr(['name' => 'parent_id', 'class' => 'form-control', 'required' => 'required'])
				->renderAsDropDown();

			return view('admin.modules.SiteModules.Templates.create')->with('dropdown', $result);
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
				'parent_id'  => 'required',
				'theme_name' => 'required',
				'active'     => 'required'
			]);

			$result = (new Template)->create($request->all());

			if ($result) {
				return redirect('admin/templates')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/templates')->with('error', 'Şablon ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request                  $request
		 * @param                          $id
		 * @return void
		 */
		public function update(Request $request, $id)
		{

			$template = (new Template)->findOrFail($id);

			// Get Type
			$type = $request->input('type');

			if ($type == 'context') {
				$template->theme_context = $request->input('value');
			} else if ($type == 'section') {
				$template->theme_name = $request->input('value');
			} else if ($type == 'page') {
				$template->page_id = $request->input('value');
			}

			$result = $template->save();
			$ajax = array();

			if ($result > 0) {
				$ajax = array('type' => 'success', 'message' => 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				$ajax = array('type' => 'error', 'message' => 'Şablon güncelleme hatası. Lütfen tekrar deneyiniz.');
			}

			echo json_encode($ajax);
		}

		/**
		 * Status Update
		 *
		 * @param Request $request
		 * @return void
		 */
		public function statusUpdate(Request $request)
		{
			$serie = (new Template)->findOrFail($request->get('pk'));
			$serie->status = $request->get('value');

			$serie->save();
		}

		/**
		 * Category Update
		 *
		 * @param Request $request
		 */
		public function categoryUpdate(Request $request)
		{
			$category = (new Template)->findOrFail($request->get('templateId'));
			$category->parent_id = $request->get('catId');

			$category->save();

			echo "ok";
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
			$template = Template::find($id);

			$result = $template->delete();

			if ($result > 0) {
				return redirect('admin/templates')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/templates')->with('error', 'Şablon silme hatası. Lütfen tekrar deneyiniz.');
			}
		}
	}
