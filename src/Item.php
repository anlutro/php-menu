<?php

namespace anlutro\Menu;

use Illuminate\Support\Str;

class Item implements ItemInterface
{
	protected $title;
	protected $url;
	protected $attributes;
	protected $glyphicon;

	public function __construct($title, $url, array $attributes = array())
	{
		$this->title = $title;
		$this->url = $url;
		$this->attributes = $this->parseAttributes($attributes);
	}

	protected function parseAttributes(array $in)
	{
		if (isset($in['glyphicon'])) {
			$this->glyphicon = $in['glyphicon'];
		}

		$out = array_except($in, ['glyphicon', 'href']);
		$out['class'] = isset($in['class']) ? explode(' ', $in['class']) : [];
		$out['id'] = isset($in['id']) ? $in['id'] : Str::slug($this->title);
		return $out;
	}

	public function getId()
	{
		return $this->attributes['id'];
	}

	public function renderLink()
	{
		return '<a href="' . $this->renderUrl() . '" ' .$this->renderAttributes() .
			'>' . $this->renderTitle() . '</a>';
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

	public function renderUrl()
	{
		return $this->url;
	}

	public function renderTitle()
	{
		$prepend = '';
		if ($this->glyphicon) {
			$prepend = "<span class=\"glyphicon glyphicon-{$this->glyphicon}\"></span> ";
		}
		return $prepend . e($this->title);
	}

	public function render()
	{
		return $this->renderLink();
	}

	public function __toString()
	{
		return $this->render();
	}
}
