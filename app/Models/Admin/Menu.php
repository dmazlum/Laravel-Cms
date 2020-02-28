<?php

	namespace App\Models\Admin;

	use Illuminate\Database\Eloquent\Model;

	/**
	 * Class Menu
	 *
	 * @package App\Models\Admin
	 */
	class Menu extends Model
	{
		public $timestamps = false;

		protected $table = 'app_modules';

		protected $fillable = array('module_type', 'module_name', 'sname', 'module_icon', 'permission');

		public static function allMenuItems()
		{
			return Menu::where('status', 1)->orderBy('sorting');
		}

	}