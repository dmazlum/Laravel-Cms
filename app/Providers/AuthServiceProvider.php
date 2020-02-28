<?php

	namespace App\Providers;

	use Illuminate\Support\Arr;
	use Illuminate\Support\Facades\Gate;
	use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

	class AuthServiceProvider extends ServiceProvider
	{
		/**
		 * The policy mappings for the application.
		 *
		 * @var array
		 */
		protected $policies = [
			'App\Model' => 'App\Policies\ModelPolicy',
		];

		/**
		 * Register any authentication / authorization services.
		 *
		 * @return void
		 */
		public function boot()
		{
			$this->registerPolicies();

			// define a admin user role
			// returns true if user role is set to admin
			Gate::define('isAdmin', function ($user) {
				return $user->role == 'admin';
			});

			// define a author user role
			// returns true if user role is set to author
			Gate::define('isAuthor', function ($user) {
				return $user->role == 'author';
			});

			// define a author user role
			// returns true if user role is set to author
			Gate::define('isRegistered', function ($user) {
				return $user->role == 'registered';
			});

			// User Permissions
			Gate::define('permission', function ($user, $sname) {

				$returnParam = false;
				$permissions = explode(',', $user->permissions);

				if ($permissions[0] == 'all') {
					$returnParam = true;
				} else {

					foreach ($permissions as $value) {
						if ($value == $sname) {
							$returnParam = true;
						}
					}
				}
				return $returnParam;
			});
		}
	}
