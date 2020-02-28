<?php

	namespace App\Http\Controllers\Admin;

	use App\Models\Admin\AdminUser;
	use App\Models\Admin\Module;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Response;

	class AdminUsersController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return Response
		 */
		public function index()
		{
			$users = AdminUser::all();

			return view('admin.modules.AdminUsers.index')->with('users', $users);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return Response
		 */
		public function create()
		{
			$modules = (new Module)->select('module_name', 'sname')->where(['status' => 1, 'module_type' => 1])->get();

			return view('admin.modules.AdminUsers.create')->with('modules', $modules);
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
				'email'  => 'required|email',
				'role'   => 'required',
				'active' => 'required'
			]);

			$user = new AdminUser();

			$user->name = $request->input('name');
			$user->email = $request->input('email');
			$user->password = bcrypt($request->input('password'));
			$user->role = $request->input('role');
			$user->permissions = $request->input('permission');
			$user->active = $request->input('active');

			$result = $user->save();

			if ($result > 0) {
				return redirect('admin/users')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/users')->with('error', 'Kullanıcı ekleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param int $id
		 * @return Response
		 */
		public function edit($id)
		{
			$user = AdminUser::find($id);
			$permissions = explode(',', $user->permissions);
			$modules = (new Module)->select('module_name', 'sname')->where(['status' => 1, 'module_type' => 1])->get();
			$permData = array();
			$key = 0;

			foreach ($permissions as $permission) {

				if ($permission == 'all') {
					$permData[$key] = array('module_name' => 'Tümü', 'sname' => 'all');
					$key++;
				}

				foreach ($modules as $module) {
					if ($permission == $module->sname) {
						$permData[$key] = array('module_name' => $module->module_name, 'sname' => $module->sname);
						$key++;
					}
				}
			}

			return view('admin.modules.AdminUsers.edit')->with(['user' => $user, 'modules' => $permData, 'allModules' => $modules]);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param int     $id
		 * @return Response
		 */
		public function update(Request $request, $id)
		{

			$this->validate($request, [
				'name'        => 'required',
				'email'       => 'required|email',
				'role'        => 'required',
				'permissions' => 'required',
				'active'      => 'required'
			]);

			$user = AdminUser::find($id);

			$user->name = $request->input('name');
			$user->email = $request->input('email');
			$user->role = $request->input('role');
			$user->permissions = $request->input('permissions');
			$user->active = $request->input('active');

			if ($request->input('password')) {
				$user->password = bcrypt($request->input('password'));
			}

			$result = $user->save();

			if ($result > 0) {
				return redirect('admin/users')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/users')->with('error', 'Kullanıcı güncelleme hatası. Lütfen tekrar deneyiniz.');
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @return Response
		 * @throws \Exception
		 */
		public function destroy($id)
		{

			$user = AdminUser::find($id);

			$result = $user->delete();

			if ($result > 0) {
				return redirect('admin/users')->with('success', 'İşleminiz başarıyla tamamlanmıştır.');
			} else {
				return redirect('admin/users')->with('error', 'Kullanıcı silme hatası. Lütfen tekrar deneyiniz.');
			}
		}
	}
