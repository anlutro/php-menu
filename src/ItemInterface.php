<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu;

interface ItemInterface
{
	/**
	 * Render the item.
	 *
	 * @return string
	 */
	public function render();

	/**
	 * Get the unique ID string for the item.
	 *
	 * @return string
	 */
	public function getId();
}
