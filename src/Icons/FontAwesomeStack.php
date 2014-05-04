<?php
namespace anlutro\Menu\Icons;

class FontAwesomeStack implements IconInterface
{
	protected $icons;
	protected $classes = ['stack'];

	public function __construct(array $icons, $modifiers = '')
	{
		$this->icons = $icons;
		if ($modifiers) {
			$classes = explode(' ', $modifiers);
			$this->classes = array_merge($this->classes, $classes);
		}
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
