<?php

	namespace App\Http\Controllers\Admin;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Storage;

	class BackupsController extends Controller
	{
		public function index()
		{
			$files = Storage::allFiles('backups');

			print_r($files);
			exit;

			return view('admin.modules.Backup.index');
		}
	}
