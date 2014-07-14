<?php
namespace anlutro\Menu\Renderers;

class BS3Renderer extends ListRenderer
{
	public function getMenuAttributes($menu)
	{
		return $this->mergeAttributes(parent::getMenuAttributes($menu),
			['class' => 'nav navbar-nav']);
	}

	public function getSubmenuAttributes($menu)
	{
		return $this->mergeAttributes(parent::getSubmenuAttributes($menu),
			['class' => 'dropdown-menu']);
	}

	public function getSubmenuAnchorAttributes($item)
	{
		return $this->mergeAttributes(parent::getSubmenuAnchorAttributes($item),
			['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
	}

	public function getDividerAttributes()
	{
		return ['class' => 'divider'];
	}

	public function getSubmenuAffix()
	{
		return ' <b class="caret"></b>';
	}

	public function getSubmenuItemAttributes($item)
	{
		return ['class' => 'dropdown'];
	}
}
