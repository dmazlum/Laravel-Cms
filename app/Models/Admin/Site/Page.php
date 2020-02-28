<?php

	namespace App\Models\Admin\Site;

	use Illuminate\Database\Eloquent\Model;
	use Nestable\NestableTrait;

	class Page extends Model
	{
		use NestableTrait;

		protected $table = 'app_pages';
		protected $fillable = ['name', 'page_id', 'section_url', 'content', 'seo_desc', 'seo_keywords', 'sorting', 'status'];
		public $timestamp = true;

		public function parent()
		{
			return $this->belongsTo('App\Models\Admin\Site\Page', 'parent_id');
		}

		public function children()
		{
			return $this->hasMany('App\Models\Admin\Site\Page', 'parent_id');
		}

		// recursive, loads all descendants
		public function childrenRecursive()
		{
			return $this->children()->with('children');
		}

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
