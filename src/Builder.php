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
	 * Text to affix to sub-menu toggles.
	 * 
	 * @var string
	 */
	protected $subMenuToggleAffix = '<b class="caret"></b>';

	/**
	 * Additional attributes to apply to sub-menu toggles.
	 * 
	 * @var array
	 */
	protected $subMenuToggleAttrs = ['data-toggle' => 'dropdown'];

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

		if (isset($options['subMenuToggleAffix'])) {
			$this->subMenuToggleAffix = $options['subMenuToggleAffix'];
		}

		if (isset($options['subMenuToggleAttrs'])) {
			$this->subMenuToggleAttrs = $options['subMenuToggleAttrs'];
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
		if (strpos($key, '.') !== false) {
			return $this->getNested($key);
		}

		return array_key_exists($key, $this->menus) ? $this->menus[$key] : null;
	}

	/**
	 * Get a nested menu.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	protected function getNested($key)
	{
		$segments = explode('.', $key);
		$data = $this->getMenu(array_shift($segments));
		if (!$data) return null;

		foreach ($segments as $key) {
			if ($data instanceof SubmenuItem) {
				$data = $data->getSubmenu();
			}

			if ($data instanceof Collection) {
				$data = $data->getItem($key);
			}  else {
				return null;
			}
		}

		return $data;
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
		if (strpos($key, '.') !== false) {
			return $this->getNested($key) !== null;
		}

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
			'subMenuToggleAffix' => $this->subMenuToggleAffix,
			'subMenuToggleAttrs' => $this->subMenuToggleAttrs,
		];

		return new Collection($attributes, $options);
	}
}
