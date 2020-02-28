<?php

	namespace App\Models\Admin\Site;

	use Illuminate\Database\Eloquent\Model;

	class Template extends Model
	{
		protected $table = 'app_themes';
		public $timestamp = true;

		protected $fillable = ['parent_id', 'theme_name', 'theme_context', 'status'];

		/**
		 * Categories
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function category()
		{
			return $this->belongsTo(Category::class, 'parent_id', null);
		}
	}
