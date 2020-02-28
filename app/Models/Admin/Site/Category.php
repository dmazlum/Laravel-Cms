<?php

	namespace App\Models\Admin\Site;

	use Illuminate\Database\Eloquent\Model;
	use Nestable\NestableTrait;

	class Category extends Model
	{
		use NestableTrait;

		protected $table = 'app_categories';
		public $timestamp = true;

		/**
		 * Build Categories Menu
		 *
		 * @param     $menu
		 * @param int $parentid
		 * @return string|null
		 */
		public function buildMenu($menu, $parentid = 0)
		{
			$result = null;
			foreach ($menu as $item)
				if ($item->parent_id == $parentid) {

					if ($item->status == 1) {
						$title = $item->name;
					} else {
						$title = '<span class="badge badge-danger">' . $item->name . '</span>';
					}

					$result .= "<li class='dd-item nested-list-item' data-order='{$item->sorting}' data-id='{$item->id}'>
	      				<div class='dd-handle dd3-handle'>&nbsp;</div>	      				
				        <div class='dd3-content'>$title
				        <div class='float-right'>
				          <a class='btn btn-success btn-sm' href='" . route('categories.edit', $item->id) . "' title='Düzenle'><span class='fa fa-pen'></span></a> 
				          <a class='btn btn-danger btn-sm' href='" . route('categories.destroy', $item->id) . "' title='Sil' onclick=\"event.preventDefault();document.getElementById('delete-form-$item->id').submit();\"><span class='fa fa-trash'></span></a>
				          <form id='delete-form-$item->id' action='" . route('categories.destroy', $item->id) . "' method=\"POST\" style=\"display: none;\">
							" . csrf_field() . " 
                            <input name=\"_method\" value=\"DELETE\" type=\"hidden\">
                            </form>
				        </div>
				        </div>
	      				
	      				" . $this->buildMenu($menu, $item->id) .
						"</li>";
				}

			return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
		}

		// Getter for the HTML menu builder
		public function getHTML($items)
		{
			return $this->buildMenu($items);
		}

		/**
		 * Pages
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function pages()
		{
			return $this->hasMany(Page::class, 'parent_id', null);
		}

	}
