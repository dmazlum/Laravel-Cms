<?php

	namespace App\Models\Admin;

	use Illuminate\Database\Eloquent\Model;

	class AdminUser extends Model
	{
		protected $table = 'app_users';
		public $primaryKey = 'id';
		public $timestamps = true;
	}
