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
	 * Array of icon resolvers.
	 *
	 * @var array
	 */
	protected static $iconResolvers = [
		'glyph' => 'anlutro\Menu\Icons\Glyphicon',
		'glyphicon' => 'anlutro\Menu\Icons\Glyphicon',
		'fa-icon' => 'anlutro\Menu\Icons\FontAwesomeIcon',
		'fa-stack' => 'anlutro\Menu\Icons\FontAwesomeStack',
	];

	/**
	 * Array keys of attributes that are not HTML attributes.
	 *
	 * @var array
	 */
	protected static $notHtmlAttributes = [
		'icon', 'href', 'affix', 'prefix', 'glyph',
		'glyphicon', 'fa-icon', 'fa-stack'
	];

	/**
	 * Add an array of icon resolvers.
	 *
	 * @param array $resolvers
	 */
	public static function addIconResolvers(array $resolvers)
	{
		static::$iconResolvers = $resolvers + static::$iconResolvers;
		static::$notHtmlAttributes = array_merge(['icon', 'href', 'affix', 'prefix'], array_keys(static::$iconResolvers));
	}

	/**
	 * @param  array  $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		if (isset($in['icon']) && $in['icon'] instanceof Icon\IconInterface) {
			$this->icon = $in['icon'];
		} else {
			foreach (static::$iconResolvers as $key => $resolver) {
				if (array_key_exists($key, $in)) {
					$this->icon = $resolver::createFromAttribute($in[$key]);
					break;
				}
			}
		}

		$out = array_except($in, static::$notHtmlAttributes);
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
