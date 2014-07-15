<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Renderers;

use anlutro\Menu\Collection;
use anlutro\Menu\Nodes\SubmenuNode;
use anlutro\Menu\Nodes\NodeInterface;

class BS3Renderer extends ListRenderer
{
	public function getMenuAttributes(Collection $menu)
	{
		return $this->mergeAttributes(parent::getMenuAttributes($menu),
			['class' => 'nav navbar-nav']);
	}

	public function getSubmenuAttributes(Collection $menu)
	{
		return $this->mergeAttributes(parent::getSubmenuAttributes($menu),
			['class' => 'dropdown-menu']);
	}

	public function getSubmenuAnchorAttributes(SubmenuNode $item)
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

	public function getSubmenuItemAttributes(SubmenuNode $item)
	{
		return ['class' => 'dropdown'];
	}
}
