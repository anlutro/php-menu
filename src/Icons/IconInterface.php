<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Icons;

interface IconInterface
{
	/**
	 * Render the icon as HTML.
	 *
	 * @return string
	 */
	public function render();

	/**
	 * Create an icon instance from an attribute passed to Collection::addItem().
	 *
	 * @param  mixed $attribute
	 *
	 * @return static
	 */
	public static function createFromAttribute($attribute);
}
