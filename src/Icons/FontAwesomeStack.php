<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Icons;

class FontAwesomeStack implements IconInterface
{
	protected $icons;
	protected $classes = ['stack'];

	public function __construct(array $icons, array $classes = array())
	{
		$this->icons = $icons;
		if ($classes) {
			$this->classes = array_merge($this->classes, $classes);
		}
	}

	public static function createFromAttribute($attribute)
	{
		if (!is_array($attribute)) {
			throw new \InvalidArgumentException('fa-stack must be an array.');
		}

		if (count($attribute) > 1 && is_string($attribute[0])) {
			return new static($attribute[1], explode(' ', $attribute[0]));
		}

		return new static($attribute);
	}

	public function render()
	{
		$classes = array_map(function($class) {
			return 'fa-'.$class;
		}, $this->classes);

		$str = '<span class="'.implode(' ', $classes).'">';

		foreach ($this->icons as $icon) {
			$str .= $icon->render();
		}

		return $str . '</span>';
	}
}
