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
	 * The menu items.
	 *
	 * @var array
	 */
	protected $items = [];

	/**
	 * The menu items, indexed by id.
	 *
	 * @var array
	 */
	protected $ids = [];

	/**
	 * The class to apply by default to sub-menus.
	 *
	 * @var string|null
	 */
	protected $subMenuClass;

	/**
	 * The class to apply by default to sub-menu toggle links.
	 *
	 * @var string
	 */
	protected $subMenuToggleClass;

	/**
	 * Text to affix to sub-menu toggles.
	 * 
	 * @var string
	 */
	protected $subMenuToggleAffix;

	/**
	 * Additional attributes to apply to sub-menu toggles.
	 * 
	 * @var array
	 */
	protected $subMenuToggleAttrs = [];

	/**
	 * @param array $attributes
	 * @param array $options
	 */
	public function __construct(array $attributes = array(), array $options = array())
	{
		$this->attributes = $this->parseAttributes($attributes);

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
	 * @param  array  $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		$out = $in;
		if (isset($in['id']) && !Str::startsWith('menu-', $in['id'])) {
			$out['id'] = 'menu-' . $in['id'];
		}
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		return $out;
	}

	/**
	 * Render the menu's attributes.
	 *
	 * @return string
	 */
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

	/**
	 * Add a new ItemInterface instance to the collection.
	 *
	 * @param  ItemInterface $item
	 * @param  int           $priority
	 *
	 * @return \anlutro\Menu\ItemInterface $item
	 */
	public function addItemInstance(ItemInterface $item, $priority = null)
	{
		$priority = (int) $priority;
		$this->items[$priority][] = $item;
		$this->ids[$item->getId()] = $item;
		return $item;
	}

	/**
	 * Add a regular item to the menu collection.
	 *
	 * @param  string $title
	 * @param  string $url
	 * @param  array  $attributes
	 * @param  int    $priority
	 *
	 * @return \anlutro\Menu\Item
	 */
	public function addItem($title, $url, array $attributes = array(), $priority = null)
	{
		return $this->addItemInstance($this->makeItem($title, $url, $attributes), $priority);
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
	 * @param  int    $priority
	 *
	 * @return \anlutro\Menu\SubmenuItem
	 */
	public function addSubmenu($title, array $attributes = array(), $priority = null)
	{
		return $this->addItemInstance($this->makeSubmenu($title, $attributes), $priority);
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
		$collection = new static(['class' => $this->subMenuClass]);

		if (isset($attributes['class']) && strpos($attributes['class'], $this->subMenuToggleClass) === false) {
			$attributes['class'] .= ' '.$this->subMenuToggleClass;
		} else {
			$attributes['class'] = $this->subMenuToggleClass;
		}

		$attributes = array_merge($this->subMenuToggleAttrs, $attributes);

		if ($this->subMenuToggleAffix) {
			$attributes['affix'] = $this->subMenuToggleAffix;
		}

		return new SubmenuItem($title, $collection, $attributes);
	}

	/**
	 * Add a divider to the items.
	 *
	 * @param  int  $priority
	 */
	public function addDivider($priority = null)
	{
		$priority = (int) $priority;
		$this->items[$priority][] = static::DIVIDER;
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
	 * Render the menu as an unordered list.
	 *
	 * @return string
	 */
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
