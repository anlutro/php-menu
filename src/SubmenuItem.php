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
 * A menu submenu item.
 */
class SubmenuItem implements ItemInterface
{
	/**
	 * The title of the submenu.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The submenu items.
	 *
	 * @var \anlutro\Menu\Collection
	 */
	protected $submenu;

	/**
	 * The submenu attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The submenu's glyphicon.
	 *
	 * @var string
	 */
	protected $glyphicon;

	/**
	 * The submenu's affix.
	 *
	 * @var string
	 */
	protected $affix;

	/**
	 * @param string $title
	 * @param \anlutro\Menu\Collection $submenu
	 * @param array  $attributes
	 */
	public function __construct($title, Collection $submenu, array $attributes = array())
	{
		$this->title = $title;
		$this->submenu = $submenu;
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

		if (isset($in['affix'])) {
			$this->affix = $in['affix'];
		}

		$out = array_except($in, ['glyphicon', 'href', 'affix']);
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		$out['id'] = isset($in['id']) ? $in['id'] : Str::slug($this->title);
		return $out;
	}

	/**
	 * Get the menu item's identifier.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->attributes['id'];
	}

	/**
	 * Get the item's submenu.
	 *
	 * @return \anlutro\Menu\Collection
	 */
	public function getSubmenu()
	{
		return $this->submenu;
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
	 * Render the item's title.
	 *
	 * @return string
	 */
	public function renderTitle()
	{
		return e($this->title);
	}

	/**
	 * Render the items's affix.
	 *
	 * @return string
	 */
	public function renderAffix()
	{
		if ($this->affix) {
			return ' '.$this->affix;
		}
	}

	/**
	 * Render the submenu item.
	 *
	 * @return string
	 */
	public function render()
	{
		$prepend = '';
		if ($this->glyphicon) {
			$prepend = "<span class=\"glyphicon glyphicon-{$this->glyphicon}\"></span> ";
		}
		return '<a href="#" ' . $this->renderAttributes() . '>' .
			$prepend . $this->renderTitle() . $this->renderAffix() .
			'</a>' . $this->submenu->render();
	}

	/**
	 * Cast the submenu item to a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}

	/**
	 * Forward missing method calls to the submenu collection if possible.
	 *
	 * @param  string $method
	 * @param  array $args
	 *
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $args)
	{
		if (is_callable([$this->submenu, $method])) {
			return call_user_func_array([$this->submenu, $method], $args);
		}

		$class = get_class($this);
		throw new \BadMethodCallException("Call to undefined method $class::$method");
	}
}
