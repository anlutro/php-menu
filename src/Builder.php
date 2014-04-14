<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu;

use Illuminate\Support\Str;

/**
 * The top-level menu builder that contains information about the whole menu
 * system.
 */
class Builder
{
	/**
	 * The menus.
	 *
	 * @var array
	 */
	protected $menus = [];

	/**
	 * The class to apply by default to top-level menus.
	 *
	 * @var string
	 */
	protected $topMenuClass = 'nav navbar-nav';

	/**
	 * The class to apply by default to sub-menus.
	 *
	 * @var string
	 */
	protected $subMenuClass = 'dropdown-menu';

	/**
	 * The class to apply by default to sub-menu toggle links.
	 *
	 * @var string
	 */
	protected $subMenuToggleClass = 'dropdown-toggle';

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array())
	{
		if (isset($options['topMenuClass'])) {
			$this->topMenuClass = $options['topMenuClass'];
		}

		if (isset($options['subMenuClass'])) {
			$this->subMenuClass = $options['subMenuClass'];
		}

		if (isset($options['subMenuToggleClass'])) {
			$this->subMenuToggleClass = $options['subMenuToggleClass'];
		}
	}

	/**
	 * Create a new menu.
	 *
	 * @param  string $key
	 * @param  array  $attributes
	 *
	 * @return \anlutro\Menu\Collection
	 */
	public function createMenu($key, array $attributes = array())
	{
		if (isset($this->menus[$key])) {
			throw new \InvalidArgumentException("Menu $key already exists");
		}

		$attributes['id'] = isset($attributes['id']) ? $attributes['id'] : $key;
		$attributes['class'] = isset($attributes['class']) ? $attributes['class'] : $this->topMenuClass;

		return $this->menus[$key] = $this->makeMenuCollection($attributes);
	}

	/**
	 * Get a menu.
	 *
	 * @param  string $key
	 *
	 * @return \anlutro\Menu\Collection
	 */
	public function getMenu($key)
	{
		return array_key_exists($key, $this->menus) ? $this->menus[$key] : null;
	}

	/**
	 * See if a menu exists.
	 *
	 * @param  string  $key
	 *
	 * @return boolean
	 */
	public function hasMenu($key)
	{
		return array_key_exists($key, $this->menus);
	}

	/**
	 * Render a menu if it exists.
	 *
	 * @param  string $key
	 *
	 * @return string|null
	 */
	public function render($key)
	{
		if ($menu = $this->getMenu($key)) return $menu->render();
	}

	/**
	 * Make a new menu collection instance.
	 *
	 * @param  array  $attributes
	 *
	 * @return \anlutro\Menu\Collection
	 */
	protected function makeMenuCollection(array $attributes)
	{
		$options = [
			'subMenuClass' => $this->subMenuClass,
			'subMenuToggleClass' => $this->subMenuToggleClass,
		];

		return new Collection($attributes, $options);
	}
}
