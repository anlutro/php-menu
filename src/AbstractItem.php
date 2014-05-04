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
 * A menu item.
 */
abstract class AbstractItem
{
	/**
	 * The title of the item.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The item's attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The icon associated with the item.
	 *
	 * @var \anlutro\Menu\Icons\IconInterface
	 */
	protected $icon;

	/**
	 * @param  array  $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		if (isset($in['icon']) && $in['icon'] instanceof Icon\IconInterface) {
			$this->icon = $in['icon'];
		} else if (isset($in['glyphicon'])) {
			$this->icon = new Icons\Glyphicon($in['glyphicon']);
		} else if (isset($in['fa-icon'])) {
			$this->icon = new Icons\FontAwesomeIcon($in['fa-icon']);
		}

		$out = array_except($in, ['icon', 'glyphicon', 'fa-icon', 'fa-stack', 'href', 'affix']);
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		$out['id'] = isset($in['id']) ? $in['id'] : Str::slug($this->title);
		return $out;
	}

	/**
	 * Get the identifier of the item.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->attributes['id'];
	}

	/**
	 * Render the item as a link.
	 *
	 * @return string
	 */
	public function renderLink()
	{
		if ($icon = $this->renderIcon()) {
			$icon .= ' ';
		}

		return '<a href="' . $this->renderUrl() . '" ' .$this->renderAttributes() .
			'>' . $icon . $this->renderTitle() . '</a>';
	}

	/**
	 * Render the item's URL.
	 *
	 * @return string
	 */
	abstract public function renderUrl();

	/**
	 * Render the item's attributes.
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
	 * Render the item's icon.
	 *
	 * @return string
	 */
	public function renderIcon()
	{
		return $this->icon ? $this->icon->render() : '';
	}

	/**
	 * Render the item's title.
	 *
	 * @return string
	 */
	public function renderTitle()
	{
		return e($this->title);
	}

	/**
	 * Render the item's font awesome icon.
	 *
	 * @return string
	 */
	protected function renderFAIcon($icon)
	{
		$classes = array_map(function($class) use(&$stacked) {
			return 'fa-'.$class;
		}, explode(' ', $icon));

		array_unshift($classes, 'fa');

		return '<i class="'.implode(' ', $classes).'"></i>';
	}

	protected function renderFAStack($stack)
	{
		
	}

	/**
	 * Render the item.
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->renderLink();
	}

	/**
	 * Cast the item to a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}
