<?php
namespace anlutro\Menu\Renderers;

use anlutro\Menu\Collection;
use anlutro\Menu\SubmenuItem;

class ListRenderer
{
	public function render($menu)
	{
		return $this->renderUnorderedList($this->renderItems($menu->getSortedItems()), $this->getMenuAttributes($menu));
	}

	public function renderSubmenu($menu)
	{
		return $this->renderUnorderedList($this->renderItems($menu->getSortedItems()), $this->getSubmenuAttributes($menu));
	}

	public function renderItems(array $items)
	{
		$str = '';

		foreach ($items as $item) {
			$str .= $this->renderItem($item);
		}

		return $str;
	}

	public function renderItem($item)
	{
		if ($item == Collection::DIVIDER) {
			return $this->renderListItem('', $this->getDividerAttributes());
		}

		if ($item instanceof SubmenuItem) {
			$submenuLink = $this->renderAnchor($item->renderIcon().$item->getTitle().$this->getSubmenuAffix(), '#', $this->getSubmenuAnchorAttributes($item));
			return $this->renderListItem($submenuLink.$this->renderSubmenu($item->getSubmenu()), $this->getSubmenuItemAttributes($item));
		}

		return $this->renderListItem($this->renderAnchor($item->renderIcon().$item->getTitle(), $item->getUrl(), $this->getItemAnchorAttributes($item)));
	}

	public function renderUnorderedList($items, array $attributes = array())
	{
		return '<ul'.$this->attributes($attributes).'>'.$items.'</ul>';
	}

	public function renderListItem($title, array $attributes = array())
	{
		return '<li'.$this->attributes($attributes).'>'.$title.'</li>';
	}

	public function renderAnchor($title, $href, array $attributes)
	{
		return '<a'.$this->attributes(['href' => $href] + $attributes).'>'.$title.'</a>';
	}

	public function getMenuAttributes($menu)
	{
		$attributes = $menu->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu--'.$attributes['id'];
		}
		return $attributes;
	}

	public function getSubmenuAttributes($menu)
	{
		$attributes = $menu->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu--'.$attributes['id'];
		}
		return $attributes;
	}

	public function getDividerAttributes()
	{
		return ['class' => 'divider'];
	}

	public function getItemAnchorAttributes($item)
	{
		$attributes = $item->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu-item--'.$attributes['id'];
		}
		return $attributes;
	}

	public function getSubmenuAffix()
	{
		return '';
	}

	public function getSubmenuAnchorAttributes($item)
	{
		$attributes = $item->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu-item--'.$attributes['id'];
		}
		return $attributes;
	}

	public function getSubmenuItemAttributes($item)
	{
		return [];
	}

	public function mergeAttributes(array $attributes, array $defaults)
	{
		if (isset($attributes['class']) && isset($defaults['class'])) {
			if (is_string($attributes['class'])) {
				$attributes['class'] = explode(' ', $attributes['class']);
			}
			$attributes['class'] = array_filter($attributes['class']);

			if (is_string($defaults['class'])) {
				$defaults['class'] = explode(' ', $defaults['class']);
			}
			$defaults['class'] = array_filter($defaults['class']);

			$attributes['class'] = implode(' ', array_unique($attributes['class'] + $defaults['class']));
			unset($defaults['class']);
		}

		return $attributes + $defaults;
	}

	public function attributes(array $attributes)
	{
		$str = '';

		foreach ($attributes as $key => $value) {
			if (is_array($value)) {
				$value = implode(' ', $value);
			}
			if ($key == 'class' && $value == '') {
				continue;
			}
			$str .= " $key=\"$value\"";
		}

		return $str;
	}
}
