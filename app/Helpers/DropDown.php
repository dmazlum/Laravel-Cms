<?php

	namespace App\Helpers;

	class DropDown
	{

		/**
		 * Get Status
		 *
		 * @param bool $selected
		 */
		public static function get_status($selected = false)
		{
			$status = array(
				'Aktif'   => 1,
				'Deaktif' => 0
			);

			foreach ($status as $key => $value) {

				if ($selected == $value) {
					$select = "selected";
				} else {
					$select = "";
				}

				echo '<option value="' . $value . '" ' . $select . '>' . $key . '</option>' . PHP_EOL;
			}
		}


		/**
		 * Get Social Media Icons
		 *
		 * @param bool $selected
		 */
		public static function get_icons($selected = false)
		{

			// Dropdown
			$icons = array(
				'Facebook'  => 'fa-facebook-square',
				'Twitter'   => 'fa-twitter',
				'Google+'   => 'fa-google-plus-square',
				'Instagram' => 'fa-instagram',
				'Linkedin'  => 'fa-linkedin',
				'Pinterest' => 'fa-pinterest-square',
				'Vimeo'     => 'fa-vimeo-square',
				'Youtube'   => 'fa-youtube-square'
			);

			foreach ($icons as $key => $value) {

				if ($selected == $value) {
					$select = "selected";
				} else {
					$select = "";

				}

				echo '<option value="' . $value . '" ' . $select . '>' . $key . '</option>' . PHP_EOL;
			}
		}


		/**
		 * Get Roles
		 *
		 * @param bool $selected
		 */
		public static function get_role($selected = false)
		{

			// Dropdown
			$icons = array(
				'Yönetici'  => 'admin',
				'Kullanıcı' => 'author'
			);

			foreach ($icons as $key => $value) {

				if ($selected == $value) {
					$select = "selected";
				} else {
					$select = "";

				}

				echo '<option value="' . $value . '" ' . $select . '>' . $key . '</option>' . PHP_EOL;
			}
		}

	}