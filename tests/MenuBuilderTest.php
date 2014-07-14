<?php

class MenuBuilderTest extends PHPUnit_Framework_TestCase
{
	protected function makeBuilder(array $options = array())
	{
		return new anlutro\Menu\Builder($options);
	}

	public function testCreateMenuIsStored()
	{
		$builder = $this->makeBuilder();
		$this->assertFalse($builder->hasMenu('left'));
		$builder->createMenu('left');
		$this->assertTrue($builder->hasMenu('left'));
		$this->assertInstanceOf('anlutro\Menu\Collection', $builder->getMenu('left'));
	}

	public function testGetNested()
	{
		$builder = $this->makeBuilder();
		$this->assertFalse($builder->hasMenu('one.two.three'));
		$this->assertNull($builder->getMenu('one.two.three'));
		$menu = $builder->createMenu('one');
		$submenu1 = $menu->addSubmenu('two');
		$submenu2 = $submenu1->addSubmenu('three');
		$this->assertTrue($builder->hasMenu('one.two.three'));
		$this->assertSame($submenu2, $builder->getMenu('one.two.three'));
	}

	public function testRenderSimpleMenu()
	{
		$builder = $this->makeBuilder();
		$menu = $builder->createMenu('left');
		$menu->addItem('Test Item 1', '/url-1', ['class' => 'foo-bar']);
		$menu->addItem('Test Item 2', '/url-2', ['data-foo' => 'bar']);
		$menu->addSubmenu('Test Submenu');
		$menu->getItem('test-submenu')->addItem('Test Item 3', '/url-3');
		$menu->getItem('test-submenu')->addItem('Test Item 4', '/url-4');
		$str = $builder->render('left');
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
