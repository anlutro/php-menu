<?php

namespace anlutro\Menu;

use Illuminate\Support\Str;

class SubmenuItem implements ItemInterface
{
	protected $title;
	protected $submenu;
	protected $attributes;
	protected $glyphicon;

	public function __construct($title, Collection $submenu = null, array $attributes = array())
	{
		$this->title = $title;
		$this->submenu = $submenu ?: new Collection(['class' => 'dropdown-menu']);
		$this->attributes = $this->parseAttributes($attributes);
	}

	protected function parseAttributes(array $in)
	{
		if (isset($in['glyphicon'])) {
			$this->glyphicon = $in['glyphicon'];
		}

		$out = array_except($in, ['glyphicon', 'href']);
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		$out['class'][] = 'dropdown-toggle';
		$out['id'] = isset($in['id']) ? $in['id'] : Str::slug($this->title);
		$out['data-toggle'] = 'dropdown';
		return $out;
	}

	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getSubmenu()
	{
		return $this->submenu;
	}

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

	public function renderTitle()
	{
		return e($this->title);
	}

	public function render()
	{
		$prepend = '';
		if ($this->glyphicon) {
			$prepend = "<span class=\"glyphicon glyphicon-{$this->glyphicon}\"></span> ";
		}
		return '<a href="#" ' . $this->renderAttributes() . '>' .
			$prepend . $this->renderTitle() . ' <b class="caret"></b></a>' .
			$this->submenu->render();
	}

	public function __toString()
	{
		return $this->render();
	}

	public function __call($method, $args)
	{
		if (is_callable([$this->submenu, $method])) {
			return call_user_func_array([$this->submenu, $method], $args);
		}

		throw new \BadMethodCallException;
	}
}
