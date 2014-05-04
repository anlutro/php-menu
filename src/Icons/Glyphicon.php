<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Icons;

class Glyphicon implements IconInterface
{
	protected $icon;

	public function __construct($icon)
	{
		$this->icon = $icon;
	}

	public static function createFromAttribute($attribute)
	{
		return new static($attribute);
	}

	public function render()
	{
		return "<span class=\"glyphicon glyphicon-{$this->icon}\"></span>";
	}
}
