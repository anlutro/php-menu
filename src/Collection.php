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
use Illuminate\Support\Collection as BaseCollection;

/**
 * A collection of menu items.
 */
class Collection
{
	const DIVIDER = 'divider';

	/**
	 * The menu collection's attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The menu items, stored in a multidimensional array of location => items
	 *
	 * @var ItemInterface[][]
	 */
	protected $items = [];

	/**
	 * The menu items, indexed by id.
	 *
	 * @var array
	 */
	protected $ids = [];

	/**
	 * @param Builder $builder
	 * @param array   $attributes
	 */
	public function __construct(Builder $builder, array $attributes = array())
	{
		$this->builder = $builder;
		$this->attributes = $this->parseAttributes($attributes);
	}

	/**
	 * @param  array  $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		$out = $in;
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		return $out;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * Render the menu's attributes.
	 *
	 * @return string
	 */
	public function renderAttributes()
	{
		$attributes = $this->attributes;
		if (isset($attributes['id']) && !Str::startsWith('menu--', $attributes['id'])) {
			$attributes['id'] = 'menu--'.$attributes['id'];
		}
		$attributes['class'] = implode(' ', $this->attributes['class']);
		$strings = [];
		foreach ($attributes as $key => $value) {
			if (!empty($value)) $strings[] = "$key=\"$value\"";
		}
		return implode(' ', $strings);
	}

	/**
	 * Add a new ItemInterface instance to the collection.
	 *
	 * @param  ItemInterface $item
	 * @param  int           $location
	 *
	 * @return \anlutro\Menu\ItemInterface $item
	 */
	public function addItemInstance(ItemInterface $item, $location = null)
	{
		$location = (int) $location;
		$this->items[$location][] = $item;
		$this->ids[$item->getId()] = $item;
		return $item;
	}

	/**
	 * Add a regular item to the menu collection.
	 *
	 * @param  string $title
	 * @param  string $url
	 * @param  array  $attributes
	 * @param  int    $location
	 *
	 * @return \anlutro\Menu\Item
	 */
	public function addItem($title, $url, array $attributes = array(), $location = null)
	{
		return $this->addItemInstance($this->makeItem($title, $url, $attributes), $location);
	}

	/**
	 * Make a new menu item instance.
	 *
	 * @param  string $title
	 * @param  string $url
	 * @param  array  $attributes
	 *
	 * @return \anlutro\Menu\Item
	 */
	public function makeItem($title, $url, array $attributes = array())
	{
		return new Item($title, $url, $attributes);
	}

	/**
	 * Add a submenu to the menu collection.
	 *
	 * @param  string $title
	 * @param  array  $attributes
	 * @param  int    $location
	 *
	 * @return \anlutro\Menu\SubmenuItem
	 */
	public function addSubmenu($title, array $attributes = array(), $location = null)
	{
		return $this->addItemInstance($this->makeSubmenu($title, $attributes), $location);
	}

	/**
	 * Make a new submenu item instance.
	 *
	 * @param  string $title
	 * @param  array  $attributes
	 *
	 * @return \anlutro\Menu\Item
	 */
	public function makeSubmenu($title, array $attributes = array())
	{
		$collection = new static($this->builder, ['id' => Str::slug($title)]);

		return new SubmenuItem($title, $collection, $attributes);
	}

	/**
	 * Add a divider to the items.
	 *
	 * @param  int  $location
	 */
	public function addDivider($location = null)
	{
		$location = (int) $location;
		$this->items[$location][] = static::DIVIDER;
	}

	/**
	 * Get an item from the collection.
	 *
	 * @param  string $id
	 *
	 * @return \anlutro\Menu\ItemInterface|null
	 */
	public function getItem($id)
	{
		return array_key_exists($id, $this->ids) ? $this->ids[$id] : null;
	}

	/**
	 * Determine whether the menu collection is currently empty or not.
	 *
	 * @return boolean
	 */
	public function isEmpty()
	{
		return empty($this->items);
	}

	public function getSortedItems()
	{
		$sorted = $this->items;
		ksort($sorted);
		return array_flatten($sorted);
	}

	/**
	 * Render the menu as an unordered list.
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->builder->renderMenu($this);
	}
}
