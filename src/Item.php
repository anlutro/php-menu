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
class Item implements ItemInterface
{
	/**
	 * The title of the item.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The URL the item links to.
	 *
	 * @var string
	 */
	protected $url;

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
	 * @param string $title
	 * @param string $url
	 * @param array  $attributes
	 */
	public function __construct($title, $url, array $attributes = array())
	{
		$this->title = $title;
		$this->url = $url;
		$this->attributes = $this->parseAttributes($attributes);
	}

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

		$out = array_except($in, ['glyphicon', 'href']);
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
	 * Render the item's URL.
	 *
	 * @return string
	 */
	public function renderUrl()
	{
		return $this->url;
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
			$prepend = "<span class=\"glyphicon glyphicon-{$this->glyphicon}\"></span> ";
		}
		return $prepend . e($this->title);
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
