<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Nodes;

use Illuminate\Support\Str;

/**
 * A menu item.
 */
abstract class AbstractNode
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
	 * @param  array $in
	 *
	 * @return array
	 */
	protected function parseAttributes(array $in)
	{
		if (isset($in['icon']) && $in['icon'] instanceof Icons\IconInterface) {
			$this->icon = $in['icon'];
		} else {
			/** @var Icons\IconInterface $resolver */
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

	public function getTitle()
	{
		return $this->title;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function getIcon()
	{
		return $this->icon;
	}
}
