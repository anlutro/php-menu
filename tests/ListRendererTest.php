<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;

class ListRendererTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function renderFullMenu()
	{
		$renderer = new \anlutro\Menu\Renderers\BS3Renderer();
		$builder = new \anlutro\Menu\Builder();
		$menu = $builder->createMenu('left');
		$menu->addItem('Test Item 1', '/url-1', ['class' => 'foo-bar', 'glyph' => 'foo']);
		$menu->addItem('Test Item 2', '/url-2', ['data-foo' => 'bar', 'fa-icon' => 'bar']);
		$submenu = $menu->addSubmenu('Test Submenu');
		$submenu->addItem('Test Item 3', '/url-3');
		$submenu->addItem('Test Item 4', '/url-4');
		$expected = str_replace(["\n","\t"], '', '<ul id="menu--left" class="nav navbar-nav">
		<li><a href="/url-1" class="foo-bar" id="menu-item--test-item-1"><span class="glyphicon glyphicon-foo"></span>Test Item 1</a></li>
		<li><a href="/url-2" data-foo="bar" id="menu-item--test-item-2"><i class="fa fa-bar"></i>Test Item 2</a></li>
		<li class="dropdown"><a href="#" class="dropdown-toggle" id="menu-item--test-submenu" data-toggle="dropdown">
		Test Submenu <b class="caret"></b></a><ul id="menu--test-submenu" class="dropdown-menu">
		<li><a href="/url-3" id="menu-item--test-item-3">Test Item 3</a></li>
		<li><a href="/url-4" id="menu-item--test-item-4">Test Item 4</a></li>
		</ul></li></ul>');
		$this->assertEquals($expected, $renderer->render($menu));
	}
}
