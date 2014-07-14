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
	 * The name of the class of the default renderer to use.
	 *
	 * @var string
	 */
	protected $defaultRenderer;

	/**
	 * @param array  $options
	 * @param string $defaultRenderer
	 */
	public function __construct(array $options = array(), $defaultRenderer = null)
	{
		$this->defaultRenderer = $defaultRenderer ?: __NAMESPACE__.'\Renderers\BS3Renderer';
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
	 * @return string
	 */
	public function render($key, RendererInterface $renderer = null)
	{
		if (!$this->hasMenu($key)) {
			return '';
		}

		return $this->renderMenu($this->getMenu($key), $renderer);
	}

	public function renderMenu(Collection $menu, RendererInterface $renderer = null)
	{
		if ($renderer === null) {
			$renderer = $this->getDefaultRenderer();
		}

		return $renderer->render($menu);
	}

	protected function getDefaultRenderer()
	{
		return new $this->defaultRenderer;
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
		return new Collection($this, $attributes);
	}

	public function addIconResolvers(array $resolvers)
	{
		Item::addIconResolvers($resolvers);
	}
}
