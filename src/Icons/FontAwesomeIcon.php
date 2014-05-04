<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Icons;

class FontAwesomeIcon implements IconInterface
{
	protected $classes;

	public function __construct(array $classes)
	{
		$this->classes = $classes;
	}

	public static function createFromAttribute($attribute)
	{
		return new static(explode(' ', $attribute));
	}

	public function render()
	{
		$classes = array_map(function($class) {
			return 'fa-'.$class;
		}, $this->classes);

		array_unshift($classes, 'fa');

		return '<i class="'.implode(' ', $classes).'"></i>';
	}
}
