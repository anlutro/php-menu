<?php

namespace anlutro\Menu;

use Illuminate\Support\Str;
use Illuminate\Support\Collection as BaseCollection;

class Collection// extends BaseCollection
{
	const DIVIDER = 'divider';

	protected $items = [];
	protected $ids;

	public function __construct(array $attributes = array())
	{
		$this->attributes = $this->parseAttributes($attributes);
	}

	protected function parseAttributes(array $in)
	{
		$out = $in;
		if (isset($in['id']) && !Str::startsWith('menu-', $in['id'])) {
			$out['id'] = 'menu-' . $in['id'];
		}
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		return $out;
	}

	public function renderAttributes()
	{
		$attributes = $this->attributes;
		$attributes['class'] = implode(' ', $this->attributes['class']);
		$strings = [];
		foreach ($attributes as $key => $value) {
			if (!empty($value)) $strings[] = "$key=\"$value\"";
		}
		return implode(' ', $strings);
	}

	public function addItemInstance(ItemInterface $item, $priority = null)
	{
		$priority = (int) $priority;
		$this->items[$priority][] = $item;
		$this->ids[$item->getId()] = $item;
		return $item;
	}

	public function addItem($title, $url, array $attributes = array(), $priority = null)
	{
		return $this->addItemInstance($this->makeItem($title, $url, $attributes), $priority);
	}

	public function makeItem($title, $url, array $attributes = array())
	{
		return new Item($title, $url, $attributes);
	}

	public function addSubmenu($title, array $attributes = array(), $priority = null)
	{
		return $this->addItemInstance($this->makeSubmenu($title, $attributes), $priority);
	}

	public function makeSubmenu($title, array $attributes = array())
	{
		return new SubmenuItem($title, null, $attributes);
	}

	public function addDivider()
	{
		$this->items[] = 'divider';
	}

	public function getItem($id)
	{
		return array_key_exists($id, $this->ids) ? $this->ids[$id] : null;
	}

	public function render()
	{
		$items = '';
		$sorted = $this->items;
		ksort($sorted);
		foreach (array_flatten($sorted) as $item) {
			if ($item === static::DIVIDER) $items .= '<li class="divider"></li>';
			else $items .= '<li>'.$item->render().'</li>';
		}
		return '<ul '.$this->renderAttributes().'>'.$items.'</ul>';
	}
}
