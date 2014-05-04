<?php
namespace anlutro\Menu\Icons;

class Glyphicon implements IconInterface
{
	protected $icon;

	public function __construct($icon)
	{
		$this->icon = $icon;
	}

	public function render()
	{
		return "<span class=\"glyphicon glyphicon-{$this->icon}\"></span>";
	}
}
