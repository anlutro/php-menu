<?php
namespace anlutro\Menu\Icons;

class FontAwesomeIcon implements IconInterface
{
	protected $classes;

	public function __construct($icon)
	{
		$this->classes = explode(' ', $icon);
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
