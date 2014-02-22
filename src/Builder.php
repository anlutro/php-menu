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

	public function createMenu($key, array $attributes = array())
	{
		if (isset($this->menus[$key])) {
			throw new \InvalidArgumentException("Menu $key already exists");
		}

		$attributes['id'] = isset($attributes['id']) ? $attributes['id'] : $key;
		$attributes['class'] = isset($attributes['class']) ? $attributes['class'] : $this->topMenuClass;

		return $this->menus[$key] = $this->makeMenuCollection($attributes);
	}

	public function getMenu($key)
	{
		return array_key_exists($key, $this->menus) ? $this->menus[$key] : null;
	}

	public function hasMenu($key)
	{
		return array_key_exists($key, $this->menus);
	}

	public function render($key)
	{
		if ($menu = $this->getMenu($key)) return $menu->render();
	}

	protected function makeMenuCollection(array $attributes)
	{
		return new Collection($attributes);
	}
}
