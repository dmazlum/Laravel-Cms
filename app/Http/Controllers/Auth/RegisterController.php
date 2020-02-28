<?php

	namespace App\Http\Controllers\Auth;

	use App\AppUser;
	use App\CustomUser;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Foundation\Auth\RegistersUsers;

	class RegisterController extends Controller
	{


		use RegistersUsers;

		/**
		 * Where to redirect users after registration.
		 *
		 * @var string
		 */
		protected $redirectTo = '/admin';

		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			$this->middleware('guest');
		}

		/**
		 * Get a validator for an incoming registration request.
		 *
		 * @param array $data
		 * @return \Illuminate\Contracts\Validation\Validator
		 */
		protected function validator(array $data)
		{
			return Validator::make($data, [
				'name'     => 'required|string|max:255',
				'username' => 'required|string|max:255|unique:app_users',
				'email'    => 'required|string|email|max:255|unique:app_users',
				'password' => 'required|string|min:6|confirmed',
			]);
		}

		/**
		 * Create a new user instance after a valid registration.
		 *
		 * @param array $data
		 * @return \App\AppUser
		 */
		protected function create(array $data)
		{
			return AppUser::create([
				'name'     => $data['name'],
				'username' => $data['username'],
				'email'    => $data['email'],
				'password' => bcrypt($data['password']),
				'role'     => $data['role'],
				'active'   => 1,
			]);
		}
	}