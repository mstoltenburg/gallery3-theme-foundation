<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2013 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

class foundation_event_Core {

	static function user_menu($menu, $theme)
	{
		$menu->view('topbar.html')->css_class('right');

		$profile = $menu->get('user_menu_edit_profile');

		if ($profile) {
			$elements = $menu->elements;
			$menu->elements = array();
			$menu->append($submenu = Menu::factory("submenu")
							->id("user_profile")
							->label($profile->label));

			$submenu->elements = $elements;

			$profile->label = t('User profile');
			$profile->view(null);
		}

		self::_changeView($menu);
	}

	static function site_menu($menu, $theme, $item_css_selector)
	{
		$menu->remove("home");

		$menu->view('topbar.html')->css_class('left');

		self::_changeView($menu);
	}

	private static function _changeView($menu)
	{
		foreach ($menu->elements as $element) {
			if ($element instanceof Menu) {
				$element->view('topbar.html');
				self::_changeView($element);
			}
		}
	}
}