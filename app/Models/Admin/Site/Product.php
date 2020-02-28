<?php

	namespace App\Models\Admin\Site;

	use Illuminate\Database\Eloquent\Model;
	use Nestable\NestableTrait;

	class Product extends Model
	{
		use NestableTrait;

		protected $table = 'app_products';
		protected $fillable = ['name', 'page_id', 'content', 'seo_desc', 'seo_keywords', 'sorting', 'status'];
		public $timestamp = true;

		public function parent()
		{
			return $this->belongsTo('App\Models\Admin\Site\Product', 'parent_id');
		}

		public function children()
		{
			return $this->hasMany('App\Models\Admin\Site\Product', 'parent_id');
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
			return $this->belongsTo(ProductCategory::class, 'parent_id', null);
		}

	}
