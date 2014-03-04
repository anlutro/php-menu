<?php

namespace anlutro\Menu;

use Illuminate\Support\Str;

class Builder
{
	protected $menus = [];
	protected $topMenuClass = 'nav navbar-nav';

	public function __construct(array $options = array())
	{
		if (isset($options['top-menu-class'])) {
			$this->topMenuClass = $options['top-menu-class'];
		}
	}

	/**
	 * Create a new menu.
	 *
	 * @param  string $key
	 * @param  array  $attributes
	 *
	 * @return Collection
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
	 * @return Collection
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
	 * @return Collection
	 */
	protected function makeMenuCollection(array $attributes)
	{
		return new Collection($attributes);
	}
}
