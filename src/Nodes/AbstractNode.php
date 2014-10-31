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
	 * Optional HTML prefix for the node.
	 *
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * Optional HTML suffix for the node.
	 *
	 * @var string
	 */
	protected $suffix = '';

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
		'icon', 'href', 'suffix', 'prefix', 'glyph',
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
		static::$notHtmlAttributes = array_merge(['icon', 'href', 'suffix', 'prefix'],
			array_keys(static::$iconResolvers));
	}

	/**
	 * @param  array $attributes
	 *
	 * @return array
	 */
	protected function parseAttributes(array $attributes)
	{
		if (isset($attributes['icon']) && $attributes['icon'] instanceof Icons\IconInterface) {
			$this->icon = $attributes['icon'];
		} else {
			/** @var Icons\IconInterface $resolver */
			foreach (static::$iconResolvers as $key => $resolver) {
				if (array_key_exists($key, $attributes)) {
					$this->icon = $resolver::createFromAttribute($attributes[$key]);
					break;
				}
			}
		}

		if (isset($attributes['class'])) {
			if (is_string($attributes['class'])) {
				$attributes['class'] = explode(' ', $attributes['class']);
			}
		} else {
			$attributes['class'] = [];
		}

		if (isset($attributes['suffix'])) {
			$this->suffix = $attributes['suffix'];
		}
		if (isset($attributes['prefix'])) {
			$this->prefix = $attributes['prefix'];
		}

		$attributes['id'] = isset($attributes['id']) ? $attributes['id'] : Str::slug($this->title);

		return array_except($attributes, static::$notHtmlAttributes);
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
		return $this->prefix.e($this->title).$this->suffix;
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
