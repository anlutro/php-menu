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

interface RendererInterface
{
	public function render(Collection $menu);
}
