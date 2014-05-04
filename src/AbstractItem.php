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
	 * The glyphicon of the item.
	 *
	 * @var string
	 */
	protected $glyphicon;

	/**
	 * The font awesome icon of the item.
	 *
	 * @var string
	 */
	protected $fontAwesome;

	/**
	 * @param  array  $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		if (isset($in['glyphicon'])) {
			$this->glyphicon = $in['glyphicon'];
		}

		if (isset($in['fa-icon'])) {
			$this->fontAwesome = $in['fa-icon'];
		}

		$out = array_except($in, ['glyphicon', 'fa-icon', 'href', 'affix']);
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
		return '<a href="' . $this->renderUrl() . '" ' .$this->renderAttributes() .
			'>' . $this->renderTitle() . '</a>';
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
	 * Render the item's title.
	 *
	 * @return string
	 */
	public function renderTitle()
	{
		$prepend = '';

		if ($this->glyphicon) {
			$prepend .= "<span class=\"glyphicon glyphicon-{$this->glyphicon}\"></span> ";
		}

		if ($this->fontAwesome) {
			$prepend .= $this->renderFAIcon() . ' ';
		}

		return $prepend . e($this->title);
	}

	/**
	 * Render the item's font awesome icon.
	 *
	 * @return string
	 */
	protected function renderFAIcon()
	{
		$classes = array_map(function($class) use(&$stacked) {
			return 'fa-'.$class;
		}, explode(' ', $this->fontAwesome));

		array_unshift($classes, 'fa');

		return '<i class="'.implode(' ', $classes).'"></i>';
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
