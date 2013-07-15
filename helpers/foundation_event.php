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

	const TEMPLATE_DROPDOWN = 'dropdown.html';
	const TEMPLATE_TOPBAR   = 'topbar.html';

	const CLASS_VIEW_MENU   = 'button secondary';

	static function album_menu($menu, $theme)
	{
		self::_addMenuClassRecursive($menu, self::CLASS_VIEW_MENU);
	}

	static function photo_menu($menu, $theme)
	{
		self::_addMenuClassRecursive($menu, self::CLASS_VIEW_MENU);
	}

	static function movie_menu($menu, $theme)
	{
		self::_addMenuClassRecursive($menu, self::CLASS_VIEW_MENU);
	}

	static function tag_menu($menu, $theme)
	{
		self::_addMenuClassRecursive($menu, self::CLASS_VIEW_MENU);
	}

	static function context_menu($menu, $theme, $item, $thumb_css_selector)
	{
		$menu->view('dropdown.html')->css_class('context-menu-dropdown');

		self::_changeMenuRecursive($menu, self::TEMPLATE_DROPDOWN, $item);
	}

	static function user_menu($menu, $theme)
	{
		$menu->view(self::TEMPLATE_TOPBAR)->css_class('right');

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

		self::_changeMenuRecursive($menu, self::TEMPLATE_TOPBAR);
	}

	static function site_menu($menu, $theme, $item_css_selector)
	{
		$menu->remove("home");

		$menu->view(self::TEMPLATE_TOPBAR)->css_class('left');

		self::_changeMenuRecursive($menu, self::TEMPLATE_TOPBAR);
	}

	private static function _changeMenuRecursive($menu, $view, $item = null)
	{
		foreach ($menu->elements as $element) {
			if ($element instanceof Menu) {
				$element->view($view);

				if ($item && empty($element->css_id)) {
					$element->css_id($item->id);
				}

				self::_changeMenuRecursive($element, $view);
			}
		}
	}

	private static function _addMenuClassRecursive($menu, $class)
	{
		$menu->css_class('button-group radius even-' . count($menu->elements));

		foreach ($menu->elements as $element) {
			if ($element instanceof Menu) {
				self::_changeMenuRecursive($element, $class);
			}
			else {
				$element->css_class(trim("{$element->css_class} $class"));
			}
		}
	}
}
