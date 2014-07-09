<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;
use Mockery as m;

class ListRendererTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function render()
	{
		$renderer = new \anlutro\Menu\Renderers\ListRenderer();
		$builder = new \anlutro\Menu\Builder();
		$menu = $builder->createMenu('left');
		$menu->addItem('Test Item 1', '/url-1', ['class' => 'foo-bar']);
		$menu->addItem('Test Item 2', '/url-2', ['data-foo' => 'bar']);
		$menu->addSubmenu('Test Submenu');
		$menu->getItem('test-submenu')->addItem('Test Item 3', '/url-3');
		$menu->getItem('test-submenu')->addItem('Test Item 4', '/url-4');
		$str = $renderer->render($menu);
		$expected = str_replace(["\n","\t"], '', '<ul id="menu--left" class="nav navbar-nav">
		<li><a href="/url-1" class="foo-bar" id="menu-item--test-item-1">Test Item 1</a></li>
		<li><a href="/url-2" data-foo="bar" id="menu-item--test-item-2">Test Item 2</a></li>
		<li><a href="#" data-toggle="dropdown" class="dropdown-toggle" id="menu-item--test-submenu">
		Test Submenu <b class="caret"></b></a><ul class="dropdown-menu">
		<li><a href="/url-3" id="menu-item--test-item-3">Test Item 3</a></li>
		<li><a href="/url-4" id="menu-item--test-item-4">Test Item 4</a></li>
		</ul></li></ul>');
		$this->assertEquals($expected, $str);
	}
}
