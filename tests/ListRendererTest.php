<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;
use Mockery as m;

class ListRendererTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function renderSubmenuItem()
	{
		$renderer = new \anlutro\Menu\Renderers\BS3Renderer();
		$submenu = new \anlutro\Menu\Collection(new \anlutro\Menu\Builder(), ['class' => 'bar baz', 'id' => 'test-title']);
		$item = new \anlutro\Menu\SubmenuItem('Test Title', $submenu, []);
		$expected = str_replace(["\n","\t"], '', '<li class="dropdown">
			<a href="#" class="dropdown-toggle" id="menu-item--test-title" data-toggle="dropdown">
			Test Title <b class="caret"></b></a>
			<ul class="bar baz" id="menu--test-title"></ul></li>');
		$this->assertEquals($expected, $renderer->renderItem($item));
	}

	/** @test */
	public function renderFullMenu()
	{
		$renderer = new \anlutro\Menu\Renderers\BS3Renderer();
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
		<li class="dropdown"><a href="#" class="dropdown-toggle" id="menu-item--test-submenu" data-toggle="dropdown">
		Test Submenu <b class="caret"></b></a><ul id="menu--test-submenu" class="dropdown-menu">
		<li><a href="/url-3" id="menu-item--test-item-3">Test Item 3</a></li>
		<li><a href="/url-4" id="menu-item--test-item-4">Test Item 4</a></li>
		</ul></li></ul>');
		$this->assertEquals($expected, $str);
	}
}
